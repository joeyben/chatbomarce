<?php

namespace App\Http\Controllers;

use App\Repository\MessagesRepository;
use App\Repository\QuestionAnswerRepository;
use App\Repository\WhatsappUserRepository;
use App\Repository\FeedbackRepository;
use App\Repository\NachrichtenRepository;


class HomeController extends Controller
{
    private $messageRepository;
    private $whatsappUserRepository;
    private $questionAnswerRepository;
    private $feedbackRepository;
    private $nachrichtenRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessagesRepository $messageRepository, WhatsappUserRepository $whatsappUserRepository, QuestionAnswerRepository $questionAnswerRepository, FeedbackRepository $feedbackRepository, NachrichtenRepository $nachrichtenRepository )
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->questionAnswerRepository = $questionAnswerRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->nachrichtenRepository = $nachrichtenRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = "dashboard";
        $messageCount = $this->messageRepository->countMessages();
        return view('dashboard', ['page' => $page, 'messageCount' => $messageCount]);
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
        }catch (\Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function nachrichten()
    {
        $nachrichten = $this->nachrichtenRepository->getNachrichten();
        return view('pages.nachrichten', ['nachrichten' => $nachrichten]);
    }

    public function feedbackLog()
    {
        $usersFeedback = $this->feedbackRepository->getUsersFeedback();
        return view('pages.feedbacklog', ['usersFeedback' => $usersFeedback]);
    }
}

