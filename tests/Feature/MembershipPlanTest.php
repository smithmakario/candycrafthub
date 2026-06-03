<?php

namespace Tests\Feature;

use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipPlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_active_membership_plans(): void
    {
        MembershipPlan::factory()->create(['name' => 'The Taster', 'is_active' => true, 'sort_order' => 1]);
        MembershipPlan::factory()->create(['name' => 'Hidden Plan', 'is_active' => false, 'sort_order' => 2]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('The Taster')
            ->assertDontSee('Hidden Plan');
    }

    public function test_guest_cannot_access_membership_plans_admin(): void
    {
        $this->get(route('membership-plans.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_membership_plan(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('membership-plans.store'), [
            'name' => 'The Taster',
            'tagline' => 'Perfect for light snacking',
            'price' => 12500,
            'billing_interval' => 'mo',
            'features' => "5 Premium treats\nCurated flavor profile",
            'button_text' => 'Select Plan',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('membership-plans.index'));
        $this->assertDatabaseHas('membership_plans', [
            'name' => 'The Taster',
            'price' => 12500,
        ]);
    }

    public function test_authenticated_user_can_update_membership_plan(): void
    {
        $user = User::factory()->create();
        $plan = MembershipPlan::factory()->create(['name' => 'Old Plan']);

        $response = $this->actingAs($user)->put(route('membership-plans.update', $plan), [
            'name' => 'The Explorer',
            'tagline' => $plan->tagline,
            'price' => 22000,
            'billing_interval' => 'mo',
            'features' => "10 Handpicked treats\nExclusive vinyl stickers",
            'button_text' => 'Subscribe Now',
            'is_featured' => true,
            'badge_text' => 'Most Popular',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('membership-plans.index'));
        $this->assertDatabaseHas('membership_plans', [
            'id' => $plan->id,
            'name' => 'The Explorer',
            'is_featured' => true,
        ]);
    }

    public function test_authenticated_user_can_delete_membership_plan(): void
    {
        $user = User::factory()->create();
        $plan = MembershipPlan::factory()->create();

        $response = $this->actingAs($user)->delete(route('membership-plans.destroy', $plan));

        $response->assertRedirect(route('membership-plans.index'));
        $this->assertDatabaseMissing('membership_plans', ['id' => $plan->id]);
    }
}
