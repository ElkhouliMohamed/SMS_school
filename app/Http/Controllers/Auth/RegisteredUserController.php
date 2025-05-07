<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'string', Rule::in(['admin', 'teacher', 'accountant', 'student'])],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
                function ($attribute, $value, $fail) use ($request) {
                    $role = $request->role;
                    if ($role === 'admin' && !str_contains($value, '#Admin_Adlab')) {
                        $fail('The password for admin must contain "#Admin_Adlab".');
                    } elseif ($role === 'accountant' && !str_contains($value, '#account')) {
                        $fail('The password for accountant must contain "#account".');
                    } elseif ($role === 'teacher' && !str_contains($value, '#teacher')) {
                        $fail('The password for teacher must contain "#teacher".');
                    }
                },
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);

        event(new Registered($user));

        Auth::login($user);

        // Role-based redirection
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('accountant')) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('dashboard');
    }
}
