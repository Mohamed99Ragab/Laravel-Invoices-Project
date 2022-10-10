<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Add_Invoice extends Notification
{
    use Queueable;
    private $invoice_id;
    private $invoice_number;

    public function __construct(Invoice $invoice)
    {
        $this->invoice_id = $invoice->id;
        $this->invoice_number = $invoice->invoice_num;
    }


    public function via($notifiable)
    {
        return ['database'];
    }




    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'invoice_id' => $this->invoice_id,
            'invoice_number'=>$this->invoice_number,
            'user' => auth()->user()->name,

        ];
    }
}
