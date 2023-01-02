<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //use custom traits for response
    use HttpResponses;


    /**
     * Login method is responsible for user login
     * It will accept a custom request parameter
     * who is responsible to validate data
     */
    public function login(LoginUserRequest $request)
    {
        //validate request data which is email and password
        $request->validated($request->only(['email', 'password']));

        /**
         * Validate if user exist or not before login
         * if not exist then return error 
         * */
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Incorrect Credential', 401);
        };

        //elequoent model to find user from database
        $user = User::where('email', $request->email)->first();


        //return the the response with user data and token
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }


    /**
     * Register method is responsible to user register
     * It will accept a custom request parameter
     * which will validate the user request data
     */
    public function register(RegisterUserRequest $request)
    {
        //validate the user request
        $request->validated($request->only(['name', 'email', 'password']));

        //create a user using elequoent model
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //return the success response
        return $this->success([
            'user' => $user
        ], "Registered successfully");
    }


    /**
     * Get logged in use information
     */

    public function user()
    {
        if (!Auth::check()) {
            return $this->error('', 'You are not authenticated', 401);
        }

        $user = Auth::user();
        return $this->success(['user' => $user]);
    }



    /**
     * Log out method is responsible to log out a user
     */
    public function logout()
    {
        /**
         * Get the current authenticated user and
         * then delete the token from the database;
         */
        Auth::user()->currentAccessToken()->delete();

        //return the success response 
        return $this->success(
            '',
            'You have succesfully been logged out!'
        );
    }
}
