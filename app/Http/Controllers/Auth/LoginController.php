<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Cookie;
use Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $fields = array(
            // "name" => "krishn",
            "email" => $request->email,
            // "mobile" => "9979678595",
            "password" =>  $request->password,
        );

        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post(env('API_URL')."/login", [
            "email" => $request->email,
            "password" =>  $request->password,
        ]);
        $response->successful();

        // Determine if the response has a 400 level status code...
        dd($response->clientError());
        
        // Determine if the response has a 500 level status code...
        dd($response->serverError());

        $token=json_decode($response);
        Cookie::queue('access_token', $token->access_token, $token->expires_in);
        
        // echo $token->access_token;
        if (Auth::once($credentials)) {
            return redirect($this->redirectTo);
        }

        
    }
}
