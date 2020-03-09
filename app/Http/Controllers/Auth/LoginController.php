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
        if ($response->successful()) {
            $token=json_decode($response);
            Cookie::queue('access_token', $token->access_token, $token->expires_in);
            
            return redirect($this->redirectTo);
        }elseif ($response->clientError()) {
            echo $response;
            return redirect()->back()->with('error','Login Credentials Incorect!');
        }elseif ($response->serverError()) {
            echo $response;
        }

        
    }
    public function logoutApi(){
        $response =Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.Cookie::get('access_token'),
            // 'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6NTc1OFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MzY3ODE0OCwiZXhwIjoxNTgzNjc4NzQ4LCJuYmYiOjE1ODM2NzgxNDgsImp0aSI6ImJMRmFoa0d5cFVZeTFGWUMiLCJzdWIiOjQsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.volUpn9DmbW3BjSl09bbvPjG7lcYjWXqnWL8zyh29oc',
        ])->post(env('API_URL')."/logout", [
            
        ]);
        if ($response->successful()) {
            $token=json_decode($response);
            Cookie::queue('access_token', '', -1);
            return redirect('/');
        }elseif ($response->clientError()) {
            echo $response;
            return redirect()->back()->with('error','Login Credentials Incorect!');
        }elseif ($response->serverError()) {
            echo $response;
        }
        
    }
}
