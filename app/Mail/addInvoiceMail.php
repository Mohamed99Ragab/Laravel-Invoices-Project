<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class addInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice_id;


    public function __construct($id)
    {
        $this->invoice_id = $id;
    }


    public function build()
    {
        return $this->markdown('emails.add_invoice');
    }
}
