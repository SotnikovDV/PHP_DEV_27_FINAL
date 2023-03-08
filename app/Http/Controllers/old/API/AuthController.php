<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
/*
use Illuminate\Validation\Validator;*/

class AuthController extends Controller
{

public function token(Request $request)
{
   /*  $validator = Validator::make($request->all(), [
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:8']
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
    } */
    $validated = $request->validated();

    //$user = User::where('email', $request->email)->first();
    $user = User::where('email', $validated['email'])->first();
    // 2

    if (!$user || !Hash::check($validated['password'], $user->password)) {
        return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
    }
    // 3

    return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    // 4
}
}
