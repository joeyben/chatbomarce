<?php

namespace App\Http\Controllers;

use App\Repository\MessagesRepository;
use App\Repository\WhatsappUserRepository;

class HomeController extends Controller
{
    private $messageRepository;
    private $whatsappUserRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessagesRepository $messageRepository, WhatsappUserRepository $whatsappUserRepository)
    {
        $this->middleware('auth');
        $this->messageRepository = $messageRepository;
        $this->whatsappUserRepository = $whatsappUserRepository;
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
