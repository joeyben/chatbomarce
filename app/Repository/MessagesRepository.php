<?php


namespace App\Repository;
use App\Models\Message;

class MessagesRepository extends BaseRepository
{
    const MODEL = Message::class;

    public function addMessage($message, $whatsappNr){
            $whatsapp = new Message();
            $whatsapp->whatsapp = $whatsappNr;
            $whatsapp->message = $message;
            $whatsapp->status = $this->handleMessages($message);
           return $whatsapp->save();
    }

    private function handleMessages($message){
        $response = "";
        switch ($message) {
            case 'q1':
                $response = 1;
                break;
            case 'q2':
                $response = 1;
                break;
            case 'q3':
                $response = 1;
                break;
            default:
                $response = 0;
                break;
        }
        return $response;
    }

    public function getMessage($message){
        return $this->query()->where('whatsapp' , $message)->get();
    }

    public function getMessages(){
        return $this->query()->get();
    }

    public function getMessagesByWhatsapp($whatsappnr){
        return $this->query()->where('whatsapp', $whatsappnr)->get();
    }


}
