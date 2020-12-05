<?php


namespace App\Repository;
use App\Models\Nachrichten;
use App\Models\UserNachricht;
use Twilio\Rest\Client;

class NachrichtenRepository extends BaseRepository
{
	const MODEL = Nachrichten::class;
    private $whatsappUserRepository;
    private $feedbackRepository;
    public function __construct(WhatsappUserRepository $whatsappUserRepository, FeedbackRepository $feedbackRepository)
    {
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->feedbackRepository = $feedbackRepository;
    }

	public function addNachrichten($message, $position)
    {
		$nachrichten = new Message();
        $nachrichten->message = $message;
        $nachrichten->position = $position;
        return $nachrichten->save();
    }

    public function getNachrichten()
    {
    	return $this->query()->get();
    }

    public function getCurrentNachricht($userId)
    {
        $currentNachricht = UserNachricht::where('user_id', $userId)->orderBy('id', 'DESC')->first();
        if(!$currentNachricht){
            return $this->query()->first();
        }else{
            return $this->query()->where('id', '>', $currentNachricht->nachricht_id)->first();
        }
    }

    public function handleNachrichtenForAllUsers()
    {
        $users = $this->whatsappUserRepository->getWhatsappUsersByStatus(1);
        foreach ($users as $user){
            $currentNachricht = $this->getCurrentNachricht($user->id);
            $this->sendNachrichtToUser($currentNachricht, $user);
        }
    }

    public function sendNachrichtToUser($nextNachricht, $user)
    {
        if(!$nextNachricht){
            $nextNachricht = __('chatbot.done');
            $this->sendWhatsAppMessage($nextNachricht, "whatsapp:".$user->whatsapp);
            $this->whatsappUserRepository->updateStatus($user->whatsapp, 2);
            $currentFeedback = $this->feedbackRepository->getCurrentFeedback($user->whatsapp);
            $this->sendWhatsAppMessage($currentFeedback->question, "whatsapp:".$user->whatsapp);
        }else{
            $this->sendWhatsAppMessage($nextNachricht->message, "whatsapp:".$user->whatsapp);
            $this->addUserNachricht($nextNachricht->id, $user->id);
        }
    }

    public function addUserNachricht($nachrichtID, $userID)
    {
        $nachricht = new UserNachricht();
        $nachricht->user_id = $userID;
        $nachricht->nachricht_id = $nachrichtID;
        return $nachricht->save();
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
