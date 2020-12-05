<?php

namespace App\Http\Controllers\Api\V1;

use App\Repository\FeedbackRepository;
use App\Repository\MessagesRepository;
use App\Repository\NachrichtenRepository;
use App\Repository\WhatsappUserRepository;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChatBotController extends APIController
{
    private $whatsappUserRepository;
    private $messageRepository;
    private $feedbackRepository;
    private $nachrichtenRepository;
    /**
     * ChatBotController constructor.
     */
    public function __construct(WhatsappUserRepository $whatsappUserRepository,
                                MessagesRepository $messageRepository, FeedbackRepository $feedbackRepository,
                                NachrichtenRepository $nachrichtenRepository)
    {
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->messageRepository = $messageRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->nachrichtenRepository = $nachrichtenRepository;
    }
    //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
    //$out->writeln($this->whatsappUserRepository->getUserByWhatsapp($whatsappNr));
    public function listenToReplies(Request $request)
    {
        $originalWhatsappNr = $request->input('From');// whatsapp:+1234143443
        $whatsappNr = str_replace('whatsapp:', '', $originalWhatsappNr); //+1234143443
        $message = $request->input('Body');

        //add new user if not exist
        $newUser = $this->whatsappUserRepository->addUser($whatsappNr);
        $userStatus = $this->whatsappUserRepository->getStatusByWhatsapp($whatsappNr);
        if($newUser){
            try {
                $this->sendWhatsAppMessage(__('chatbot.welcome'), $originalWhatsappNr);

            } catch (RequestException $th) {
                $response = json_decode($th->getResponse()->getBody());
                $this->sendWhatsAppMessage($response->message, $whatsappNr);
            }
        }
        switch ($userStatus) {
            case 0:
                break;
            case 1:
                if($message === "halt"){
                    $this->whatsappUserRepository->updateStatus($whatsappNr, 0);
                    $response = __('chatbot.stop');
                }else if($message === "next"){
                    $user = $this->whatsappUserRepository->getUserByWhatsapp($whatsappNr);
                    $nextNachricht = $this->nachrichtenRepository->getCurrentNachricht($user->id);
                    $this->nachrichtenRepository->sendNachrichtToUser($nextNachricht, $user);
                }else{
                    $response = $this->whatsappUserRepository->handleMessages($message, $whatsappNr, $newUser);

                    $this->messageRepository->addMessage($message, $whatsappNr);
                }

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
