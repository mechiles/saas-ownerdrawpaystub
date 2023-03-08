<?php

namespace App;

class OpenAI {
    public function generateText($prompt) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
            "model": "gpt-3.5-turbo",
            "prompt": "$prompt",
            "temperature": 0.2,
            "top_p": 1,
            "frequency_penalty": 0,
            "presence_penalty": 0
            }',
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".env('OPENAI_API_KEY'),
            "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['error' => $err], 400);
        } else {
            return response()->json(['response' => $response]);
        }
    }
}
?>