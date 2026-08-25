<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::query()->with('services')->latest()->get();

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact): View
    {
        $contact->load('services');

        if ($contact->status === 'nuevo') {
            $contact->update(['status' => 'leido']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['nuevo', 'leido', 'respondido', 'archivado'])],
        ]);

        $contact->update($data);

        return redirect()->route('admin.contacts.show', $contact)->with('status', 'Estado del contacto actualizado.');
    }
}
