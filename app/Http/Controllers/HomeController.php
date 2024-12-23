<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OpenAi;
use function Pest\Laravel\json;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        return redirect('/user/' . Auth::user()->login);
    }

    public function gpt(Request $request)
    {
//        $data = array(
//            "model" => "gpt-3.5-turbo",
//            "prompt" =>  $request->question, //Your question or request
//            "temperature" => 0.7,
//            "max_tokens" => 2048,
//            "top_p" => 1,
//            "frequency_penalty" => 0,
//            "presence_penalty" => 0,
//            "stop" => [
//                "Human:",
//                "AI:"
//            ]
//        );

        $data = array(
            "model" => "gpt-3.5-turbo",
            "messages" => [
                "role" => "user",
                "content" => $request->question
            ],
            "temperature" => 0.7
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer pk-LvaioWPWgYRZJYSNrPhmwKIDTWFzfUGFItZiEMXLbcyWmzkL';
//        $headers[] = 'Authorization: Bearer pk-LvaioWPWgYRZJYSNrPhmwKIDTWFzfUGFItZiEMXLbcyWmzkL';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($response, true);
//        return json_decode($response, true)['choices'][0]['text'];
    }

    public function renderGPT()
    {
        $result = 'Привет, я - бот, созданный на основе чата GPT!';
        return inertia('GPT', compact('result'));
    }
}
