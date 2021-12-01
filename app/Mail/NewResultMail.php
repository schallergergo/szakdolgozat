<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Result;
use Illuminate\Support\Facades\Lang;

class NewResultMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $result;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Result $result)
    {
        $this->result=$result;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Lang::get("New result"))->markdown('mail.result.new', 
            [
                    'result' => $this->result,
                ]);
    }
}
