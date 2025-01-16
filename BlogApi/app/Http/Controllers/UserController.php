<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // Get email and password from the request
        $email = $request->input('email');
        $password = $request->input('password');

        // Find the user by email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Verify the password using Hash::check (for hashed passwords)
            if (Hash::check($password, $user->password)) {
                // Generate a Sanctum token
                $token = $user->createToken('YourAppName')->plainTextToken;

                return response()->json([
                    'message' => 'Login Success',
                    'token' => $token // Return the generated token
                ], 200);
            } else {
                // Incorrect password
                return response()->json(['message' => 'Invalid Password'], 422);
            }
        } else {
            // Email not found
            return response()->json(['message' => 'Invalid Email'], 422);
        }
    }

    function register(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $name = $request->input('name');
        $user = new User();
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->name = $name;
        $user->save();
        return response()->json(['message' => 'User Created'], 201);
    }
}
