<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Specify the middleware for this controller
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's profile
     */
    public function show($user_id = NULL)
    {
        $user = NULL;

        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = Auth::user();
        }

        return view('pages.profile')->with('user', $user);
    }

    /**
     * Updates the user's profile
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'avatar'=>'string|max:255',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255'
        ]);

        $user = Auth::user();
        $user->avatar = $request->input('avatar');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        if ($user->save()) {
            return redirect('/profile')->with('status', 'Profile updated successfully!');
        }
    }

    /**
     * Display all users that are students
     */
    public function showAll($class_id)
    {
        return view('pages.teacher.students/show_all', [
            'users' => User::all(),
            'class_id' => $class_id
        ]);
    }
}
