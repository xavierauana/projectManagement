<?php

namespace App\Http\Controllers;

use App\ViewModels\HomeViewModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('home', new HomeViewModel);
    }

    public function profile() {
        $user = request()->user();

        return view("profile", compact('user'));
    }

    public function updateProfile(Request $request) {
        $user = $request->user();

        $data = $this->validate($request, [
            'first_name' => 'required',
            'last_name'  => 'required',
            'password'   => 'nullable|confirmed|min:6',
        ]);
        if (!is_null($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        unset($data['password']);

        $user->update($data);

        return redirect()->route('profile')->withMessage('Profile updated!');
    }
}
