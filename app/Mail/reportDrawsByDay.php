<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class reportDrawsByDay extends Mailable
{
    use Queueable, SerializesModels;

    public $drawsByDay;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($drawsByDay)
    {
        $this->drawsByDay = $drawsByDay;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Relatório diário de sorteios');
        $this->from('admin@loterbeloteriabr.com', 'Loteria BR');
        $this->to('gilbertogomes_adv@hotmail.com', 'Gilberto');
//        $this->to('kelvervagal@gmail.com', 'Kelver');
//        $this->to('ggomes5757@gmail.com', 'Gilberto');
        return $this->markdown('mailReport.drawByDay', [
            'drawsByDay' => $this->drawsByDay
        ]);
    }
}
