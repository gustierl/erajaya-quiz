<?php

namespace App\Jobs;

use App\Notifications\RequestAtkEmailNotificationHrd;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class RequestAtkJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $to;
    protected $data;
    public $timeout = 7200; // 2 hours
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$data1)
    {
        $this->to = $user;
        $this->data = $data1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->to, new RequestAtkEmailNotificationHrd($this->data));
    }
}
