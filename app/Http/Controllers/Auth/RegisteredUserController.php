<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\User;
use App\UserType;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $user = User::create([
            ...$request->safe()->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'address',
                'state',
                'country',
            ]),
            'password' => Hash::make($request->password),
            'user_type' => UserType::Customer,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('customer.dashboard', absolute: false));
    }
}
