<?php

namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use App\Repository\QuestionAnswerRepository;
use App\Repository\FeedbackRepository;


class MainController extends APIController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $feedbackRepository;
    private $questionAnswerRepository;
    public function __construct(QuestionAnswerRepository $questionAnswerRepository, FeedbackRepository $feedbackRepository )
    {
        $this->questionAnswerRepository = $questionAnswerRepository;
        $this->feedbackRepository = $feedbackRepository;
    }


    /**
     * Show the application dashboard.
     *
     * @return boolean
     */
    public function addqa(Request $request)
    {
        $question = $request->get('question');
        $answer = $request->get('answer');
        $user_input = $request->get('user_input');
        $position = $request->get('position');
        return $this->questionAnswerRepository->addQuestionAnswer($question, $answer, $user_input, $position);
    }

    /**
     *
     *
     * @return array
     */
    public function getQA()
    {
        $textes = $this->questionAnswerRepository->getQuestionAnswer();
        return $textes;
    }

    public function addfb(Request $request)
    {
        $question = $request->get('question');
        $position = $request->get('position');
        return $this->feedbackRepository->addFeedback($question, $position);
    }

    public function getFeedback()
    {
        return $this->feedbackRepository->getFeedback();
    }
}
