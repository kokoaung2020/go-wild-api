<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthApiController extends Controller
{
    public function register(Request $request){
        $request->validate([
            "name"=>"required|min:3",
            "email"=>"required|unique:users",
            "password"=>"required|min:8|confirmed",
            "photo"=>"nullable|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($request->file("photo")){

            $newName = uniqid()."_User.".$request->photo->extension();
            $request->photo->store("storage/$newName");
            Storage::delete("public/".$user->photo);
            $user->photo = $newName;
        }

        $user->save();

        $token = $user->createToken("phone")->plainTextToken;

        return response()->json([
            "message"=>"User created",
            "token"=>$token,
            "success" => true
        ],200);
    }



    public function login(Request $request){
        $request->validate([
            "email"=>"required",
            "password"=>"required|min:8"
        ]);

        if(Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken("phone")->plainTextToken;

            return response()->json([
                "message"=>"Login successful",
                "success" => true,
                "token" => $token
            ]);
        }

        return response()->json([
            "message"=>"User not found",
            "success" => false
        ],401);
    }


    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "message"=>"Logout Successfully",
            "success" => true
        ],200);
    }


    public function logoutAll(){
        Auth::user()->tokens()->delete();

        return response()->json(["message"=>"Logout successfully"],204);
    }
}
