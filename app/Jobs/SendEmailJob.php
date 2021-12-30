<?php

namespace App\Jobs;

use App\Interfaces\SendMessageInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailMassage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SendMessageInterface $emailMassage)
    {
        $this->emailMesssage = $emailMassage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($name, $email, $ticket)
    {
        $this->emailMesssage->sendEmail($name, $email, $ticket);
    }
}
