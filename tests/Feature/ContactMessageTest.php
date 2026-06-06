<?php

namespace Tests\Feature;

use App\ContactSubject;
use App\Mail\ContactMessageReceived;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    public function test_contact_page_is_accessible(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertViewIs('contact.index')
            ->assertSee('Send Us a Message');
    }

    public function test_guest_can_submit_contact_form(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'Abigail Chukwu',
            'email' => 'abigail@example.com',
            'subject' => ContactSubject::GeneralInquiry->value,
            'message' => 'I would love to learn more about your candy boxes.',
        ]);

        $response->assertRedirect(route('contact').'#contact-form');
        $response->assertSessionHas('success');

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail): bool {
            return $mail->hasTo('customercare@candycrafthub.com')
                && $mail->senderName === 'Abigail Chukwu'
                && $mail->senderEmail === 'abigail@example.com'
                && $mail->contactSubject === ContactSubject::GeneralInquiry
                && $mail->messageBody === 'I would love to learn more about your candy boxes.';
        });
    }

    public function test_contact_form_requires_valid_data(): void
    {
        Mail::fake();

        $response = $this->from(route('contact'))->post(route('contact.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => 'invalid',
            'message' => 'short',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        Mail::assertNothingSent();
    }
}
