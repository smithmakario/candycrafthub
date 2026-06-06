<?php

namespace App\Http\Controllers;

use App\ContactSubject;
use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('contact.index', [
            'subjects' => ContactSubject::cases(),
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Mail::to(config('mail.customer_care.address'))
            ->send(new ContactMessageReceived(
                senderName: $validated['name'],
                senderEmail: $validated['email'],
                contactSubject: ContactSubject::from($validated['subject']),
                messageBody: $validated['message'],
            ));

        return redirect()
            ->route('contact')
            ->withFragment('contact-form')
            ->with('success', 'Thanks for reaching out! We will get back to you soon.');
    }
}
