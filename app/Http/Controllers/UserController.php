<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        $schools = School::all();

        return view('backend.users.index', compact('users', 'schools'));
    }

    public function edit(User $user)
    {
        $schools = School::orderBy('name')->get();

        return view('backend.users.edit', compact('user', 'schools'));
    }


    /**
     * Update the specified user in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_phone' => 'required|string|max:255',
            'edit_school' => 'nullable|exists:schools,id',
            'edit_role' => 'required|in:user,admin,super',
        ]);


        // Update the user's information
        $user->update([
            'name' => $validatedData['edit_name'],
            'phone' => $validatedData['edit_phone'],
            'school_id' => $validatedData['edit_school'],
            'role' => $validatedData['edit_role'],
        ]);

        // Redirect back with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);


        return view('backend.users.show', compact('user'));
    }


    public function updateRole(Request $request, User $user)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'edit_role' => 'required|in:user,admin,super',
        ]);

        // Update the user's role
        $user->update([
            'role' => $validatedData['edit_role'],
        ]);

        // Redirect back with a success message
        return redirect()->route('users.index')->with('success', 'User role updated successfully');
    }


    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user'], 500);
        }
    }

    public function resetPassword(User $user)
    {

        $user->update([
            'password' => Hash::make('cyberspace'),
        ]);

        return redirect()->back()->with('success', 'Password reset successfully to "cyberspace"');
    }

    public function passwordUpdateForm()
    {
        return view('backend.users.password-update');
    }



    public function updatePassword(Request $request)
    {
        $request->validate([

            'password' => 'required|string|min:8|confirmed',
        ]);



        $user = auth()->user();



        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully. You can now log in with your new password.');
    }





}
