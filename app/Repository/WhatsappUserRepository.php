<?php


namespace App\Repository;


use App\Models\WhatsappUser;

class WhatsappUserRepository extends BaseRepository
{
    const MODEL = WhatsappUser::class;


    public function addUser($whatsappNr)
    {
        if (!$this->countUserByWhatsapp($whatsappNr)) {
            $whatsapp = new WhatsappUser();
            $whatsapp->whatsapp = $whatsappNr;
            $whatsapp->privacy = 1;
            $whatsapp->privacy_check = 0;
            $whatsapp->last_message = \Carbon\Carbon::now();
            $whatsapp->save();
            return true;
        }
        return false;
    }

    public function checkPrivacy($whatsappNr)
    {
        $user = $this->getUserByWhatsapp($whatsappNr);
        return $user->privacy_check;
    }

    public function handlePrivacyCheck($whatsappNr)
    {
        if ($this->checkPrivacy($whatsappNr)) {
            return $this->getUserByWhatsapp($whatsappNr)->privacy;
        } else {
            return null;
        }
    }

    public function handleMessages($message, $whatsappNr)
    {
        $privacy = $this->handlePrivacyCheck($whatsappNr);
        if($privacy === "Abgelehnt"){
            return "sorry,bye";
        } elseif ($privacy === "Akzeptiert") {
            return $this->handleQuestions($message);
        }else {
            return $this->handlePrivacy($message, $whatsappNr);
        }
    }

    public function handlePrivacy($message, $whatsappNr){
        $response = "";

        switch ($message) {
            case 'p1':
                $this->updatePrivacy($whatsappNr, 1);
                $response = $this->handleQuestions($message);
                break;
            case 'p0':
                $this->updatePrivacy($whatsappNr);
                $response = "tut uns leid";
                break;
            default:
                $response = "Hallo Lieber User bitte bestätigen Sie die AGB mit p1 oder lehnen sie mit p0 ab ";
                break;
        }
        return $response;


    }
    public function handleQuestions($message){
        $response = "";

        switch ($message) {
            case 'q1':
                $response = "i ist gleich 0";
                break;
            case 'q2':
                $response = "i ist gleich 1";
                break;
            case 'q3':
                $response = "i ist gleich 2";
                break;
            default:
                $response = "Hallo Lieber User antworte mit q1, q2, q3 für die fragen: \n" .
                    "1.Frage 1 \n" .
                    "2.Frage 2 \n" .
                    "3.Frage 3 \n";
                break;
        }
        return $response;
    }

    public function getWhatsappUsers()
    {
        return $this->query()->orderBy('created_at', 'desc')->get();
    }

    public function countUserByWhatsapp($whatsappNr)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->count();
    }

    public function getUserByWhatsapp($whatsappNr)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->first();
    }

    public function getUsersbyPrivacy($privacy = 0)
    {
        return $this->query()->where('privacy', $privacy)->get();
    }

    public function updatePrivacy($whatsappNr, $privacy = 0)
    {
        return $this->query()->where('whatsapp', $whatsappNr)->update(['privacy' => $privacy, 'privacy_check' => 1]);
    }

    public function getWhatsappUser($id)
    {
        return $this->query()->where('id', $id)->first();
    }
}
