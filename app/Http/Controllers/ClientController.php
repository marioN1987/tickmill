<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Client;
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
        $allClients = Client::all();

        return Inertia::render('Clients/All', [
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
            // use asset helper method to get avatar image from storage
            'image' => asset('storage/avatars/'.$client->avatar),
            'status' => session('status'),
        ]);
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

        return Redirect::route('clients.list');
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

        return Redirect::route('clients.list');
    }
}
