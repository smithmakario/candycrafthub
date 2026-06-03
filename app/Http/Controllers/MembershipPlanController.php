<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipPlanRequest;
use App\Http\Requests\UpdateMembershipPlanRequest;
use App\Models\MembershipPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MembershipPlanController extends Controller
{
    public function index(): View
    {
        $membershipPlans = MembershipPlan::query()
            ->ordered()
            ->paginate(15);

        return view('membership-plans.index', [
            'membershipPlans' => $membershipPlans,
        ]);
    }

    public function create(): View
    {
        return view('membership-plans.create');
    }

    public function store(StoreMembershipPlanRequest $request): RedirectResponse
    {
        MembershipPlan::query()->create($this->planDataFromRequest($request));

        return redirect()
            ->route('membership-plans.index')
            ->with('success', 'Membership plan created successfully.');
    }

    public function show(MembershipPlan $membershipPlan): View
    {
        return view('membership-plans.show', [
            'membershipPlan' => $membershipPlan,
        ]);
    }

    public function edit(MembershipPlan $membershipPlan): View
    {
        return view('membership-plans.edit', [
            'membershipPlan' => $membershipPlan,
        ]);
    }

    public function update(UpdateMembershipPlanRequest $request, MembershipPlan $membershipPlan): RedirectResponse
    {
        $membershipPlan->update($this->planDataFromRequest($request));

        return redirect()
            ->route('membership-plans.index')
            ->with('success', 'Membership plan updated successfully.');
    }

    public function destroy(MembershipPlan $membershipPlan): RedirectResponse
    {
        $membershipPlan->delete();

        return redirect()
            ->route('membership-plans.index')
            ->with('success', 'Membership plan deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function planDataFromRequest(StoreMembershipPlanRequest|UpdateMembershipPlanRequest $request): array
    {
        $features = collect(preg_split('/\r\n|\r|\n/', $request->validated('features')))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all();

        return [
            'name' => $request->validated('name'),
            'tagline' => $request->validated('tagline'),
            'price' => $request->validated('price'),
            'billing_interval' => $request->validated('billing_interval'),
            'features' => $features,
            'is_featured' => $request->boolean('is_featured'),
            'badge_text' => $request->validated('badge_text'),
            'button_text' => $request->validated('button_text'),
            'sort_order' => $request->validated('sort_order'),
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
