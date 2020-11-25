<?php

namespace App\Http\Controllers\Api\V1;

use App\Repository\FeedbackRepository;
use App\Repository\MessagesRepository;
use App\Repository\WhatsappUserRepository;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChatBotController extends APIController
{
    private $whatsappUserRepository;
    private $messageRepository;
    private $feedbackRepository;
    /**
     * ChatBotController constructor.
     */
    public function __construct(WhatsappUserRepository $whatsappUserRepository, MessagesRepository $messageRepository, FeedbackRepository $feedbackRepository)
    {
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->messageRepository = $messageRepository;
        $this->feedbackRepository = $feedbackRepository;
    }
    //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
    //$out->writeln($this->whatsappUserRepository->getUserByWhatsapp($whatsappNr));
    public function listenToReplies(Request $request)
    {
        $originalWhatsappNr = $request->input('From');
        $whatsappNr = str_replace('whatsapp:', '', $originalWhatsappNr);
        $message = $request->input('Body');

        //add new user if not exist
        $this->whatsappUserRepository->addUser($whatsappNr);
        $userStatus = $this->whatsappUserRepository->getStatusByWhatsapp($whatsappNr);

        switch ($userStatus) {
            case 0:
                break;
            case 1:
                $response = $this->whatsappUserRepository->handleMessages($message, $whatsappNr);

                $this->messageRepository->addMessage($message, $whatsappNr);

                try {
                    $this->sendWhatsAppMessage($response, $originalWhatsappNr);

                } catch (RequestException $th) {
                    $response = json_decode($th->getResponse()->getBody());
                    $this->sendWhatsAppMessage($response->message, $whatsappNr);
                }
                break;
            case 2:
                $response = $this->handleFeedback($message, $whatsappNr);
                $response = $response ? $response : $this->handleFinalMessage();
                $this->sendWhatsAppMessage($response, $originalWhatsappNr);
                break;
        }

        /*$out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($userStatus);
        die();*/


        return;
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }

    public function handleFeedback($message, $whatsappUser){
        $messageInt = intval($message);
        $current_feedback = $this->feedbackRepository->getCurrentFeedback($whatsappUser);
        $current_user     = $this->whatsappUserRepository->getUserByWhatsapp($whatsappUser);

        if($messageInt > 0 && $messageInt <= 6){
            $this->feedbackRepository->addUserFeedback($messageInt, $current_feedback, $current_user);
            $current_feedback = $this->feedbackRepository->getCurrentFeedback($whatsappUser);
            return isset($current_feedback->question) ? $current_feedback->question : null;
        }else{
            return isset($current_feedback->question) ? $current_feedback->question : null;
        }
    }

    public function handleFinalMessage(){
        return __('chatbot.finalMessage');
    }
}
