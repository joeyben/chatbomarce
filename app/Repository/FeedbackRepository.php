<?php


namespace App\Repository;
use App\Models\Feedback;
use App\Models\Texte;
use App\Models\UserFeedback;

class FeedbackRepository extends BaseRepository
{
    const MODEL = Feedback::class;
    private $whatsappUserRepository;
    public function __construct(WhatsappUserRepository $whatsappUserRepository)
    {
        $this->whatsappUserRepository = $whatsappUserRepository;
    }

    public function getFeedback()
    {
        return $this->query()->get();
    }

    public function addFeedback($question, $position)
    {
        $feedback = new Feedback();
        $feedback->question = $question;
        $feedback->position = $position;
        return $feedback->save();
    }

    public function getCurrentFeedback($whatsappUser)
    {
        $user = $this->whatsappUserRepository->getUserByWhatsapp($whatsappUser);
        $userFeedback = UserFeedback::where('user_id', $user->id)->orderBy('id', 'DESC')->first();

        if(!isset($userFeedback->user_id)){
            return $this->query()->first();
        }else{
            return $this->query()->where('id', '>', $userFeedback->feedback_id)->first();
        }
    }

    public function addUserFeedback($messageInt, $currentFeedback, $currentUser)
    {
        $ufeedback = new UserFeedback();
        $ufeedback->user_id = $currentUser->id;
        $ufeedback->feedback_id = $currentFeedback->id;
        $ufeedback->rating = $messageInt;
        return $ufeedback->save();
    }

    public function getUsersFeedback()
    {
        return UserFeedback::query()->get();
    }
}
