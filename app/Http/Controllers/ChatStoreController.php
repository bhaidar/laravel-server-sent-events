<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChatStoreRequest;
use Illuminate\Support\Facades\Session;

class ChatStoreController extends Controller
{
    public function __invoke(ChatStoreRequest $request)
    {
        $prompt = $request->input('prompt');

        $existingMessages = collect($request->session()->get(Auth::id(), []));

        if ($existingMessages->count() === 0) {
            $existingMessages->push([
                'role' => 'system',
                'content' => 'You are a helpful assistant',
            ]);
        }

        $existingMessages->push([
            'role' => 'user',
            'content' => $prompt,
        ]);

        $request->session()->put(Auth::id(), $existingMessages);

        return response()->noContent();
    }
}
