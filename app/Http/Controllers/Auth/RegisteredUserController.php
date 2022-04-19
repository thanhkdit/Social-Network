<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        if ($request->hasFile('avatar')) {
            $uploadedFile = $request->file('avatar');
            $path = $uploadedFile->storeAs('avatar', 'avatar' . Carbon::now()->timestamp . '.' . $uploadedFile->getClientOriginalExtension(), 'public');
            $url = Storage::disk('public')->url($path);
            if (config('status.port')) {
                $url = str_replace('localhost', 'localhost:' . config('status.port'), $url);
            }
            $data['avatar'] = $url;
        } else {
            $data['avatar'] = 'http://localhost:8000/storage/avatar/default-avatar.png';
        }
        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
