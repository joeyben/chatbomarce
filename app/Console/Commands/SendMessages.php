<?php

namespace App\Console\Commands;

use App\Repository\NachrichtenRepository;
use Illuminate\Console\Command;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:send'; // php artisan messages:send

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $nachrichtenRepository;
    /**
     * Create a new command instance.
     * @param $nachrichtenRepository
     * @return void
     */
    public function __construct(NachrichtenRepository $nachrichtenRepository)
    {
        parent::__construct();
        $this->nachrichtenRepository = $nachrichtenRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->nachrichtenRepository->handleNachrichtenForAllUsers();
    }
}
