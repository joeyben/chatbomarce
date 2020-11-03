<?php

namespace App\Http\Controllers\Api\V1;

use App\Repository\MessagesRepository;
use App\Repository\WhatsappUserRepository;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class ChatBotController extends APIController
{
    private $whatsappUserRepository;
    private $messageRepository;
    /**
     * ChatBotController constructor.
     */
    public function __construct(WhatsappUserRepository $whatsappUserRepository, MessagesRepository $messageRepository)
    {
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->messageRepository = $messageRepository;
    }
    //$out = new \Symfony\Component\Console\Output\ConsoleOutput();
    //$out->writeln($this->whatsappUserRepository->getUserByWhatsapp($whatsappNr));
    public function listenToReplies(Request $request)
    {
        $originalWhatsappNr = $request->input('From');
        $whatsappNr = str_replace('whatsapp:', '', $originalWhatsappNr);
        $message = $request->input('Body');

        //add new user if not exist
        $userStored = $this->whatsappUserRepository->addUser($whatsappNr);

        $response = $this->whatsappUserRepository->handleMessages($message, $whatsappNr);

        $this->messageRepository->addMessage($message, $whatsappNr);

        try {
            $this->sendWhatsAppMessage($response, $originalWhatsappNr);

        } catch (RequestException $th) {
            $response = json_decode($th->getResponse()->getBody());
            $this->sendWhatsAppMessage($response->message, $whatsappNr);
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
}