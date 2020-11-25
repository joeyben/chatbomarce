<?php

namespace App\Repository;
use App\Models\Message;
use App\Models\Texte;

class QuestionAnswerRepository extends BaseRepository
{
    const MODEL = Texte::class;

    public function getQuestionAnswer()
    {
        return $this->query()->orderBy('position', 'ASC')->get();
    }

    public function addQuestionAnswer($question, $answer, $user_input, $position)
    {
        $texte = new Texte();
        $texte->questions = $question;
        $texte->answers = $answer;
        $texte->user_input = $user_input;
        $texte->position = $position;
        return $texte->save();

    }

    public function getQAByKeyword($keyword)
    {
        return $this->query()->where('user_input', 'LIKE', '%'.$keyword.'%')->get();
    }
}
