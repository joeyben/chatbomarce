<?php

namespace App\Http\Controllers\Api\V1;


class MainController extends APIController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function infos()
    {
        try {
            return "yo yo yo ";
        } catch (\Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
