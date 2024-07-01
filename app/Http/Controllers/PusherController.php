<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PusherController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function broadcast(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            broadcast(new PusherBroadcast($request->get('message')))->toOthers();
            return response()->json(['status' => 'Message broadcasted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function receive(Request $request)
    {
        return response()->json(['message' => $request->get('message')]);
    }

}

