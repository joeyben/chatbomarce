<?php


namespace App\Repository;


use App\Models\WhatsappUser;

class WhatsappUserRepository extends BaseRepository
{
    const MODEL = WhatsappUser::class;

    private $questionAnswerRepository;
    /**
     * Create a new controller instance.
     * @param $questionAnswerRepository
     * @return void
     */
    public function __construct(QuestionAnswerRepository $questionAnswerRepository)
    {
        $this->questionAnswerRepository = $questionAnswerRepository;
    }

    public function addUser($whatsappNr)
    {

        if (!$this->countUserByWhatsapp($whatsappNr)) {
            $whatsapp = new WhatsappUser();
            $whatsapp->whatsapp = $whatsappNr;
            $whatsapp->privacy = 1;
            $whatsapp->privacy_check = 1;
            $whatsapp->last_message = \Carbon\Carbon::now();
            $whatsapp->current_text = "";
            $whatsapp->save();
            return true;
        }
        return false;
    }

    public function checkPrivacy($whatsappNr)
    {
        $user = $this->getUserByWhatsapp($whatsappNr);
        return $user->privacy_check;
    }

    public function handlePrivacyCheck($whatsappNr)
    {
        if ($this->checkPrivacy($whatsappNr)) {
            return $this->getUserByWhatsapp($whatsappNr)->privacy;
        } else {
            return null;
        }
    }

    public function handleMessages($message, $whatsappNr, $newUser)
    {
        return $this->handleQuestions($message, $newUser);
    }

    public function handlePrivacy($message, $whatsappNr){
        $response = "";

        switch ($message) {
            case 'p1':
                $this->updatePrivacy($whatsappNr, 1);
                $response = $this->handleQuestions($message);
                break;
            case 'p0':
                $this->updatePrivacy($whatsappNr);
                $response = __("chatbot.privacy.cancelled");
                break;
            default:
                $response = __("chatbot.privacy.warning");
                break;
        }
        return $response;


    }
    public function handleQuestions($message, $newUser){
        $response = "";
        $QAFromKeyword = $this->questionAnswerRepository->getQAByKeyword($message);

        return isset($QAFromKeyword[0]) ? $QAFromKeyword[0]['answers'] : ($newUser ? "" : __("chatbot.questions.nothing"));
    }

    public function getWhatsappUsers()
    {
        return $this->query()->orderBy('created_at', 'desc')->get();
    }

    public function getWhatsappUsersByStatus($status)
    {
        return $this->query()->where('status', $status)->orderBy('created_at', 'desc')->get();
    }

    public function countUserByWhatsapp($whatsappNr)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->count();
    }

    public function getStatusByWhatsapp($whatsappNr)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->first()->status;
    }

    public function getUserByWhatsapp($whatsappNr)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->first();
    }

    public function getUsersbyPrivacy($privacy = 0)
    {
        return $this->query()->where('privacy', $privacy)->get();
    }

    public function updatePrivacy($whatsappNr, $privacy = 0)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->update(['privacy' => $privacy, 'privacy_check' => 1]);
    }

    public function updateStatus($whatsappNr, $status = 1)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->update(['status' => $status]);
    }

    public function getWhatsappUser($id)
    {
        return $this->query()->where('id', $id)->first();
    }
}
