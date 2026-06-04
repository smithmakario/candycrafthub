<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterSubscriberTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_subscribe_from_shop_form(): void
    {
        $response = $this->post(route('newsletter.store'), [
            'email' => 'sweet@example.com',
        ]);

        $response->assertRedirect(route('shop'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'sweet@example.com',
        ]);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        NewsletterSubscriber::factory()->create(['email' => 'sweet@example.com']);

        $response = $this->from(route('shop'))->post(route('newsletter.store'), [
            'email' => 'sweet@example.com',
        ]);

        $response->assertRedirect(route('shop'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('newsletter_subscribers', 1);
    }

    public function test_admin_can_view_newsletter_subscribers(): void
    {
        $admin = User::factory()->admin()->create();
        NewsletterSubscriber::factory()->create(['email' => 'alpha@example.com']);
        NewsletterSubscriber::factory()->create(['email' => 'beta@example.com']);

        $this->actingAs($admin)
            ->get(route('newsletter.index'))
            ->assertOk()
            ->assertSee('alpha@example.com')
            ->assertSee('beta@example.com');
    }

    public function test_customer_cannot_view_newsletter_subscribers(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)
            ->get(route('newsletter.index'))
            ->assertRedirect(route('customer.dashboard'));
    }
}
