<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventPackageRequest;
use App\Http\Requests\UpdateEventPackageRequest;
use App\Models\EventPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventPackageController extends Controller
{
    public function index(): View
    {
        $eventPackages = EventPackage::query()
            ->ordered()
            ->paginate(15);

        return view('event-packages.index', [
            'eventPackages' => $eventPackages,
        ]);
    }

    public function create(): View
    {
        return view('event-packages.create');
    }

    public function store(StoreEventPackageRequest $request): RedirectResponse
    {
        EventPackage::query()->create($this->packageDataFromRequest($request));

        return redirect()
            ->route('event-packages.index')
            ->with('success', 'Event package created successfully.');
    }

    public function show(EventPackage $eventPackage): View
    {
        return view('event-packages.show', [
            'eventPackage' => $eventPackage,
        ]);
    }

    public function edit(EventPackage $eventPackage): View
    {
        return view('event-packages.edit', [
            'eventPackage' => $eventPackage,
        ]);
    }

    public function update(UpdateEventPackageRequest $request, EventPackage $eventPackage): RedirectResponse
    {
        $eventPackage->update($this->packageDataFromRequest($request));

        return redirect()
            ->route('event-packages.index')
            ->with('success', 'Event package updated successfully.');
    }

    public function destroy(EventPackage $eventPackage): RedirectResponse
    {
        $eventPackage->delete();

        return redirect()
            ->route('event-packages.index')
            ->with('success', 'Event package deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function packageDataFromRequest(StoreEventPackageRequest|UpdateEventPackageRequest $request): array
    {
        $features = collect(preg_split('/\r\n|\r|\n/', $request->validated('features')))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all();

        $usesCustomPricing = $request->boolean('uses_custom_pricing');

        return [
            'name' => $request->validated('name'),
            'tagline' => $request->validated('tagline'),
            'price' => $usesCustomPricing ? null : $request->validated('price'),
            'price_label' => $usesCustomPricing ? $request->validated('price_label') : null,
            'price_interval' => $request->validated('price_interval'),
            'features' => $features,
            'is_featured' => $request->boolean('is_featured'),
            'badge_text' => $request->boolean('is_featured')
                ? ($request->validated('badge_text') ?: 'Most Popular')
                : null,
            'button_text' => $request->validated('button_text'),
            'sort_order' => $request->validated('sort_order'),
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
