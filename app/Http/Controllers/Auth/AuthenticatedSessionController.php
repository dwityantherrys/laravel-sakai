<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Ensure you create a new LoginRequest
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import the HTTP facade
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    // Custom authentication logic
    $credentials = $request->only('username', 'password');

    // Make an API request instead of using Auth::attempt
    $response = Http::post('http://10.25.202.144:5252/api/auth/login', $credentials);

    // Log the response for debugging
    \Log::info('API login response:', $response->json());

    if ($response->successful()) {
        // If the API returns a token or user data, you can set the session
        $token = $response->json('token'); // Adjust based on your API response

        // Save the token in the session
        $request->session()->put('api_token', $token);

        // Flash success message
        $request->session()->flash('success', 'Login successful!'); // Success message

        // Authentication passed, redirect to the intended route
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    // Handle different error scenarios based on API response
    if ($response->failed()) {
        $errorMessage = $response->json('message', 'Invalid username or password.'); // Default error message

        // Flash error message
        return back()->withErrors(['username' => $errorMessage]);
    }

    // Fallback error message
    return back()->withErrors([
        'username' => 'An unexpected error occurred. Please try again.',
    ]);
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Clear the token from the session if you stored it
        $request->session()->forget('api_token');

        return redirect('/');
    }
}
