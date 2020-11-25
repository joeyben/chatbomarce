<?php


namespace App\Repository;
use App\Models\Nachrichten;

class NachrichtenRepository extends BaseRepository
{
	const MODEL = Nachrichten::class;

	public function addNachrichten($message, $position){
		$nachrichten = new Message();
        $nachrichten->message = $nachricht;
        $nachrichten->position = $position;
        return $nachrichten->save();
    }  

    public function getNachrichten()
    {
    	return $this->query()->get();
    }  
}