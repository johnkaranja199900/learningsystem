<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\MeetingLink;
use App\Providers\RouteServiceProvider;
use App\Models\Announcement;
use Illuminate\Http\Request;

class homecontroller extends Controller
{
     
   public function about()
    {
        return view('about'); 
    }
    
    public function courses()
    {
        return view('courses');
    }

    public function error()
    {
        return view('error');
    }

    public function howto()
    {
        return view('howto');
    }

    public function login()
    {
        return view('login');
    }

    public function dashboard()
    {
        ini_set('memory_limit', '64M');

    $latestAnnouncement = Announcement::latest()->first();
    $user = Auth::user();
    $balance = $user->fees - $user->paid;
    $meetingLinks = MeetingLink::latest()->take(10)->get();
    return view('dashboard', compact('balance', 'meetingLinks', 'latestAnnouncement'));
    }

    public function signup()
    {
        return view('signup');
    }

    public function sign(Request $request)
    {
        $request->validate([
            'fname' => 'required|string',
            'sname' => 'required|string',
            'lname' => 'required|string',
            'gender' => 'required|string',
            'phone' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'unit' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        $user = new User;
        $user->fname = $request->input('fname');
        $user->sname = $request->input('sname');
        $user->lname = $request->input('lname');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->unit = $request->input('unit');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Auth::login($user);
        return redirect('/portal')->with('success', 'Registration successful!');
    }

    public function index()
    {
        return view('index');
    }

}
