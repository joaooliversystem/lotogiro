<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class reportDrawsByDay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $drawsByDay;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($drawsByDay)
    {
        $this->drawsByDay = $drawsByDay;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new \App\Mail\reportDrawsByDay($this->drawsByDay));
    }
}
