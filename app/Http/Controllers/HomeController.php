<?php

namespace App\Http\Controllers;

use App\Repository\MessagesRepository;
use App\Repository\QuestionAnswerRepository;
use App\Repository\WhatsappUserRepository;
use App\Repository\FeedbackRepository;

class HomeController extends Controller
{
    private $messageRepository;
    private $whatsappUserRepository;
    private $questionAnswerRepository;
    private $feedbackRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessagesRepository $messageRepository, WhatsappUserRepository $whatsappUserRepository, QuestionAnswerRepository $questionAnswerRepository, FeedbackRepository $feedbackRepository )
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->questionAnswerRepository = $questionAnswerRepository;
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = "dashboard";
        return view('dashboard', ['page' => $page]);
    }

    public function messages()
    {
        $messages = $this->messageRepository->getMessages();
        return view('pages.messages', ['messages' => $messages]);
    }

    public function whatsappUsers()
    {
        $users = $this->whatsappUserRepository->getWhatsappUsers();
        return view('pages.users', ['users' => $users]);
    }

    public function whatsappUser($id)
    {
        $wuser = $this->whatsappUserRepository->getWhatsappUser($id);
        $messages = $this->messageRepository->getMessagesByWhatsapp($wuser->whatsapp);
        return view('pages.wuser', ['wuser' => $wuser, 'messages' => $messages]);
    }

    public function questionAnswer()
    {
        $textes = $this->questionAnswerRepository->getQuestionAnswer();
        $class = "qa";
        return view('pages.qa', ['textes' => $textes, 'class' => $class]);

   }

    public function feedback()
    {
        $feedback = $this->feedbackRepository->getFeedback();
        return view('pages.feedback', ['feedback' => $feedback]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function infos()
    {
        try {
            return $this->responseJson("yo yo yo ");
        } catch (\Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
