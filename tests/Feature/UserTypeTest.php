<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->customer()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('customer.dashboard'));
    }

    public function test_admins_cannot_access_customer_account(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get(route('customer.dashboard'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_admins_can_access_admin_dashboard(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
    }

    public function test_customers_can_access_account_dashboard(): void
    {
        $user = User::factory()->customer()->create();

        $response = $this->actingAs($user)->get(route('customer.dashboard'));

        $response->assertOk();
    }
}
