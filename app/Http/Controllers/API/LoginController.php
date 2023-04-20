<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $token = $request->user()->createToken($request->email)->plainTextToken;

        return SuccessResource::make(['token' => $token]);
    }
}
