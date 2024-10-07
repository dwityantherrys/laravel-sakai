<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log; // Import the Log facade

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Log the incoming request
        Log::info('Login attempt', [
            'username' => $request->username,
            'timestamp' => now(),
        ]);

        // Make API request to login
        $response = Http::post('http://10.25.202.144:5252/api/auth/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        // Log the API response
        Log::info('API response', [
            'response' => $response->body(),
            'status' => $response->status(),
            'timestamp' => now(),
        ]);

        // Check if login was successful
        if ($response->successful()) {
            $data = $response->json();
            // Store API token in session
            session(['api_token' => $data['token']]); // Assuming the token is returned as 'token'
            return redirect()->route('dashboard'); // Redirect to dashboard
        }

        // If login failed, redirect back with an error
        return Redirect::back()->withErrors(['error' => 'Invalid credentials']);
    }
}
