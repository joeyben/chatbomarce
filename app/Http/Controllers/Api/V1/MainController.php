<?php

namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use App\Repository\QuestionAnswerRepository;

class MainController extends APIController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $questionAnswerRepository;
    public function __construct(QuestionAnswerRepository $questionAnswerRepository)
    {
        $this->questionAnswerRepository = $questionAnswerRepository;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function qa(Request $request)
    {
        $question = $request->get('question');
        $answer = $request->get('answer');
        $this->questionAnswerRepository->addQuestionAnswer($question, $answer);
        return $question;
    }
}
