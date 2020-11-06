<?php

namespace App\Http\Controllers;

use App\Repository\MessagesRepository;
use App\Repository\QuestionAnswerRepository;
use App\Repository\WhatsappUserRepository;

class HomeController extends Controller
{
    private $messageRepository;
    private $whatsappUserRepository;
    private $questionAnswerRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessagesRepository $messageRepository, WhatsappUserRepository $whatsappUserRepository, QuestionAnswerRepository $questionAnswerRepository)
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
        $this->whatsappUserRepository = $whatsappUserRepository;
        $this->questionAnswerRepository = $questionAnswerRepository;
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
        return view('pages.qa', ['textes' => $textes]);

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
