<?php

namespace App\Http\Controllers;

use App\Facades\OpenAI;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatStreamIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // Retrieve messages
        $payload = $request->session()->get(Auth::id());
        $payloadText = Str::squish(json_encode($payload));

        // Post a chat
        $stream = OpenAI::chat()->createStreamed([
            'model' => config('services.openai.model'),
            'temperature' => floatval(config('services.openai.temperature')),
            'max_tokens' => intval(config('services.openai.max_response_length')),
            'messages' => json_decode($payloadText, true),
        ]);

        return response()->stream(function () use ($request, $stream) {

            $messages = '';
            foreach ($stream as $response) {
                $delta = $response->choices[0]->delta->content;

                if (! $delta) {
                    continue;
                }

                $messages .= $delta;

                echo 'data: '.json_encode(['content' => nl2br($delta)])."\n\n";

                ob_flush();
                flush();

                // Break the loop if the client aborted the connection (closed the page)
                if (connection_aborted()) {
                    break;
                }
            }

            echo "event: stop\n";
            echo "data: stopped\n\n";

            // Save the complete response in session
            $existingMessages = $request->session()->get(Auth::id());
            array_merge($existingMessages, [
                'role' => 'assistant',
                'content' => $messages,
            ]);

            $request->session()->put(Auth::id(), $existingMessages);
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
