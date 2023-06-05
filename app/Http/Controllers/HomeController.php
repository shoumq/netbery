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
//            "prompt" => $request->question, //Your question or request
//            "temperature" => 0.5,
//            "max_tokens" => 4000
//        );
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/engines/gpt-3.5-turbo/completions');
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//
//        $headers = array();
//        $headers[] = 'Content-Type: application/json';
//        $headers[] = 'Authorization: Bearer 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';
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//        $response = curl_exec($ch);
//        if (curl_errno($ch)) {
//            echo 'Error:' . curl_error($ch);
//        }
//        curl_close($ch);
//        $result = json_decode($response, true)['choices'][0]['text'];
//        return $result;


        $data = array(
            "model" => "gpt-3.5-turbo",
            "prompt" =>  $request->question, //Your question or request
            "temperature" => 0.7,
            "max_tokens" => 256,
            "stop" => [
                "Human:",
                "AI:"
            ]
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.pawan.krd/v1/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer pk-LvaioWPWgYRZJYSNrPhmwKIDTWFzfUGFItZiEMXLbcyWmzkL';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($response, true)['choices'][0]['text'];
        return $result;
    }

    public function renderGPT()
    {
        $result = 'Привет, я - бот, созданный на основе чата GPT!';
        return inertia('GPT', compact('result'));
    }
}
