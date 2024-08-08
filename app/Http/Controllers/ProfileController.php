<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\StudentResult;
use App\Models\notes;
use App\Models\Course;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function prof(Request $request): View
    {
        return view('profile.updatepro', [
            'user' => $request->user(),
        ]);
    }

    public function showDashboard(): View
    {
        // Fetch the latest announcement
        $latestAnnouncement = Announcement::latest()->first();

        // Pass $latestAnnouncement to your view
        return view('dashboard', compact('latestAnnouncement'));
    }

    public function viewMarks(): View
    {
        $user = Auth::user();
        $results = $user->results;

        return view('profile.marks', compact('results'));
    }

    public function announcements(): View
    {
        // Retrieve the latest 10 announcements with their creation date
        $announcements = Announcement::latest()->take(10)->get();

        return view('profile.announcement', compact('announcements'));
    }

    public function updateprof(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Remove debugging code
        // dd($request->all(), $user->toArray());

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        // Validate the input
        $request->validate([
            'fname' => 'required|string|max:255',
            'sname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'gender' => 'required|string|max:10',
        ]);

        // Update user information
        $user->update($request->only(['fname', 'sname', 'lname', 'email', 'gender']));

        // Optionally, log some details for debugging
        \Log::info('User profile updated:', ['userId' => $user->id]);

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function listNotes(): View
    {
        $user = Auth::user();
        $notes = collect(); // Initialize an empty collection

        if ($user->paid == 0) {
            // If not paid, return a view with a message and an empty notes collection
            return view('notes.list', [
                'message' => 'You must pay the fees to access the notes.',
                'notes' => $notes,
            ]);
        }

        $userUnits = explode(',', $user->unit); // Assuming 'unit' is a comma-separated string of course IDs

        $notes = notes::with('course')
            ->whereHas('course', function ($query) use ($userUnits) {
                $query->whereIn('name', $userUnits); // Assuming 'name' is the column to match
            })
            ->get();

        return view('notes.list', [
            'notes' => $notes,
            'message' => null, // No message when notes are available
        ]);
    }

    public function viewNote(Notes $note): View
    {
        return view('notes.studentview', compact('note'));
    }
}
