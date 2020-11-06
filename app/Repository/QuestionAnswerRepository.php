<?php

namespace App\Repository;
use App\Models\Message;
use App\Models\Texte;

class QuestionAnswerRepository extends BaseRepository
{
    const MODEL = Texte::class;

    public function getQuestionAnswer()
    {
        return $this->query()->get();
    }
}
