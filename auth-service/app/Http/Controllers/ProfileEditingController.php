<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
class ProfileEditingController extends Controller
{
    
    public function updateName(Request $request)
    {
        try{
            
            $request->validate([
                'name' => 'required|string|max:255|unique:users,name,'. auth()->user()->id,
            ]);
        } 
        catch (ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }

        $user = User::find(auth()->user()->id);

        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->save();

        return response()->json(['message' => 'User name updated successfully']);

    }
    public function updateEmail(Request $request)
    {
        //dd($request);
        try{
            
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users,email'
            ]);
        } 
        catch (ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
        $user = User::find(auth()->user()->id);

        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'User email updated successfully']);

    }
}
