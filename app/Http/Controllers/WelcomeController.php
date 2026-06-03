<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __invoke(): View
    {
        return view('welcome', [
            'membershipPlans' => MembershipPlan::query()->active()->ordered()->get(),
        ]);
    }
}
