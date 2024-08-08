<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => 'required|string',
            'sname' => 'required|string',
            'lname' => 'required|string',
            'gender' => 'required|string',
            'phone' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'unit' => 'required|string',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $currentYear = date('Y');
        $lastAdmissionNumber = User::where('admission_number', 'like', 'PCC/CO/'.$currentYear.'/%')->max('admission_number');
        $lastNumber = $lastAdmissionNumber ? intval(substr($lastAdmissionNumber, -3)) : 0;
        $nextNumber = $lastNumber + 1;
        $admissionNumber = 'PCC/CO/'.$currentYear.'/'.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $user = User::create([
            'fname'=> $request->fname,
            'sname'=> $request->sname,
            'lname'=> $request->lname,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'email' => $request->email,
            'unit'=> $request->unit,
            'password' => Hash::make($request->password),
            'admission_number' => $admissionNumber, // Assign the generated admission number
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
