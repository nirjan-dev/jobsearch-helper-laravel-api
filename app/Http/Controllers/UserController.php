<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getResume(User $user)
    {
        $resume = $user->resume;

        if (! $resume) {
            return response()->json([
                'message' => 'Resume not found',
            ])->setStatusCode(404);
        }

        return response()->json(json_decode($resume->data, true));
    }

    public function saveResume(User $user, Request $request)
    {
        $request->validate([
            'data' => ['required', 'json'],
        ]);

        $resume = $user->resume;

        if (! $resume) {
            $user->resume()->create([
                'data' => $request->data,
            ]);
        } else {
            $resume->update([
                'data' => $request->data,
            ]);
        }

        return response()->json($request->data);

    }
}
