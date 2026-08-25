<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactEmail;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'company' => 'nullable|string|max:255',
            'inquiry_type' => 'required|in:servicios,propuesta_laboral,otro',
            'message' => 'required|string|min:10',
            'services' => 'nullable|array',
            'services.*' => 'integer|exists:services,id',
        ]);

        DB::transaction(function () use ($data): void {
            $contact = Contact::create($data);
            $contact->services()->sync($data['services'] ?? []);
        });

        SendContactEmail::dispatch($data);

        return back()->with('contact_success', 'Gracias, recibí tu mensaje. Me pondré en contacto a la brevedad.');
    }
}
