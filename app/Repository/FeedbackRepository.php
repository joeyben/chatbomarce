<?php


namespace App\Repository;
use App\Models\Feedback;
use App\Models\Texte;

class FeedbackRepository extends BaseRepository
{
    const MODEL = Feedback::class;

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
}
