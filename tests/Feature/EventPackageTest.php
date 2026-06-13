<?php

namespace Tests\Feature;

use App\Models\EventPackage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventPackageTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_services_page_displays_active_event_packages(): void
    {
        EventPackage::factory()->create(['name' => 'Sweet Social', 'is_active' => true, 'sort_order' => 1]);
        EventPackage::factory()->create(['name' => 'Hidden Package', 'is_active' => false, 'sort_order' => 2]);

        $this->get(route('event-services'))
            ->assertOk()
            ->assertSee('Sweet Social')
            ->assertDontSee('Hidden Package');
    }

    public function test_featured_event_package_shows_default_most_popular_badge(): void
    {
        EventPackage::factory()->featured()->create([
            'name' => 'Celebration Studio',
            'badge_text' => null,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get(route('event-services'))
            ->assertOk()
            ->assertSee('Most Popular');
    }

    public function test_guest_cannot_access_event_packages_admin(): void
    {
        $this->get(route('event-packages.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_create_event_package(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post(route('event-packages.store'), [
            'name' => 'Sweet Social',
            'tagline' => 'Up to 30 guests',
            'price' => 85000,
            'price_interval' => 'event',
            'features' => "Curated candy display\nSetup & breakdown",
            'button_text' => 'Get a Quote',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('event-packages.index'));
        $this->assertDatabaseHas('event_packages', [
            'name' => 'Sweet Social',
            'price' => 85000,
        ]);
    }

    public function test_authenticated_admin_can_create_custom_pricing_event_package(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post(route('event-packages.store'), [
            'name' => 'Grand Gala',
            'tagline' => '100+ guests',
            'uses_custom_pricing' => true,
            'price_label' => 'Custom',
            'price_interval' => 'event',
            'features' => "Multi-station dessert lounge\nDedicated event coordinator",
            'button_text' => 'Contact Us',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('event-packages.index'));
        $this->assertDatabaseHas('event_packages', [
            'name' => 'Grand Gala',
            'price' => null,
            'price_label' => 'Custom',
        ]);
    }

    public function test_authenticated_admin_can_update_event_package(): void
    {
        $user = User::factory()->admin()->create();
        $package = EventPackage::factory()->create(['name' => 'Old Package']);

        $response = $this->actingAs($user)->put(route('event-packages.update', $package), [
            'name' => 'Celebration Studio',
            'tagline' => 'Up to 80 guests',
            'price' => 185000,
            'price_interval' => 'event',
            'features' => "Full candy buffet + signage\nCustom color theme",
            'button_text' => 'Book Consultation',
            'is_featured' => true,
            'badge_text' => 'Most Popular',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('event-packages.index'));
        $this->assertDatabaseHas('event_packages', [
            'name' => 'Celebration Studio',
            'is_featured' => true,
            'badge_text' => 'Most Popular',
        ]);
    }

    public function test_authenticated_admin_can_delete_event_package(): void
    {
        $user = User::factory()->admin()->create();
        $package = EventPackage::factory()->create();

        $response = $this->actingAs($user)->delete(route('event-packages.destroy', $package));

        $response->assertRedirect(route('event-packages.index'));
        $this->assertDatabaseMissing('event_packages', ['id' => $package->id]);
    }
}
