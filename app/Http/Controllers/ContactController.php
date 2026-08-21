<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class ContactController extends BaseController
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
            'services' => 'nullable|array',
            'services.*' => 'integer|exists:services,id',
        ]);

        try {
            SendContactEmail::dispatch($data);

            return back()->with('contact_success', 'Gracias — tu mensaje fue enviado correctamente. Te contactaremos pronto.');
        } catch (\Exception $e) {
            Log::error('Contact send failed: '.$e->getMessage());
            return back()->withErrors('Ocurrió un error al enviar el mensaje. Intenta de nuevo más tarde.');
        }
    }
}
