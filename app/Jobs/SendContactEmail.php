<?php

namespace App\Jobs;

use App\Mail\ContactFormSubmitted;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        // If services were passed as IDs, replace with names for the email
        if (!empty($this->data['services']) && is_array($this->data['services'])) {
            $names = Service::whereIn('id', $this->data['services'])->pluck('name')->toArray();
            $this->data['services'] = $names;
        }

        $recipient = config('mail.from.address');
        Mail::to($recipient)->send(new ContactFormSubmitted($this->data));
    }
}
