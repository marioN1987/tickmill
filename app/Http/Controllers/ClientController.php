<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function list(Request $request): Response
    {
        $allClients = Client::paginate(10);

        return Inertia::render('Clients/List', [
            'allClients' => $allClients,
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        // check if id exists in db
        $request->validate([
             'id' => 'required|integer|exists:'.Client::class.',id'
        ]);
            
        $client = Client::where('id', $request->id)->first();

        return Inertia::render('Clients/Edit', [
            'client' => $client,
            'status' => session('status'),
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Clients/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        //proper custom validation messages
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|lowercase|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'avatar.required' => 'Please select avatar!',
            'avatar.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.'
        ]);

        //save avatar image in public storage
        $image = $request->file('avatar');
        $date = Carbon::now()->format('Y-m-d');
        $filename = $date.'/'.$request->avatar->getClientOriginalName();
        $image->storeAs('avatars', $filename, 'public');
        
        // save client details in db
        $client = Client::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'avatar' => $filename,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //create transaction entry when new client is created
        Transaction::create([
            'client_id' => $client->id,
            'amount' => 0
        ]);

        return redirect(route('clients.list'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ClientUpdateRequest $request): RedirectResponse
    {
        $request->validated();
        $client = Client::where('id', $request->id)->first();

        if($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $date = Carbon::now()->format('Y-m-d');
            $filename = $date.'/'.$request->avatar->getClientOriginalName();

            $image->storeAs('avatars', $filename, 'public');
            $client->avatar = $filename;
        }

        $client->firstname = $request->firstname;
        $client->lastname = $request->lastname;
        $client->email = $request->email;

        if ($client->isDirty('email')) {
            $client->email_verified_at = null;
        }

        $client->update();

        return redirect(route('clients.list'));
    }

    /**
     * Delete the user's account.
     */
    public function delete(Request $request): RedirectResponse
    {
        // check if id exists in db
        $request->validate([
            'id' => 'required|integer|exists:'.Client::class.',id'
        ]);

        $client = Client::where('id', $request->id)->first();

        $client->delete();

        return redirect(route('clients.list'));
    }
}
