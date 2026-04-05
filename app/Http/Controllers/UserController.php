<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('archived')) {
            $query->onlyTrashed();
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User password updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        foreach ($user->jobApplications as $jobApplication) {
            $jobApplication->job()->decrement('apply_count');
            $jobApplication->delete();
        }
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User archived successfully');
    }

    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $deletionTimeBuffer = $user->deleted_at->subSeconds(5);
        $user->restore();
        $trashedApplications = $user->jobApplications()->onlyTrashed()->where('deleted_at', '>=', $deletionTimeBuffer)->get();

        foreach ($trashedApplications as $jobApplication) {
            $jobApplication->job()->increment('apply_count');
            $jobApplication->restore();
        }

        return redirect()->back()->with('success', 'User restored successfully.');
    }
}
