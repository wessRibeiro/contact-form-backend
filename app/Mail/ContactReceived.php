<?php

namespace App\Mail;

use App\Http\Resources\Api\V1\ContactReceived as ContactReceivedResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Created by Weslley Ribeiro
 * User: Weslley Ribeiro <wess_ribeiro@hotmail.com>
 * Class ContactReceived
 * @package App\Mail
 */
class ContactReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var int
     */
    public $tries = 5;
    /**
     * @var array
     */
    public $contactReceived;

    /**
     * Create a new message instance.
     * ContactReceived constructor.
     * @param $contactReceived
     */
    public function __construct($contactReceived)
    {
        if($contactReceived instanceof ContactReceivedResource) {
            $this->contactReceived = $contactReceived->jsonSerialize();
        }else{
            $this->contactReceived = $contactReceived;
        }
    }

    /**
     * Build the message.
     * Created by Weslley Ribeiro.
     * User: Weslley Ribeiro <wess_ribeiro@hotmail.com>
     * Date 12/01/2021 15:07
     * @return ContactReceived
     */
    public function build()
    {
        return $this->view('emails.contactReceived')
            ->subject('Contato recebido - página de contato Netshow.me')
            ->attachFromStorageDisk(env('FILESYSTEM_DRIVER'),$this->contactReceived['fileUrl']);
    }
}
