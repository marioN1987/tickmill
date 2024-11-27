<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //proper custom validation messages
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Client::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'avatar.required' => 'Please select avatar!',
            'avatar.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.'
        ]);

        $image = $request->file('avatar');
        $date = Carbon::now()->format('Y-m-d');
        $filename = $date.'/'.$request->avatar->getClientOriginalName();

        //save image in db with current date
        $image->storeAs('avatars', $filename, 'public');

        $user = Client::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'avatar' => $filename,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //Auth::login($user);
        return redirect(route('welcome'));
       // return redirect(route('dashboard', absolute: false));
    }
}
