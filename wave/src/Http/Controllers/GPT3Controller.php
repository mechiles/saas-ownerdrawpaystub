<?php

namespace Wave\Http\Controllers;

use App\Http\Controllers\Controller;

class GPT3Controller extends Controller
{
    ///OpenAI GPT3 Engine names :
    private $engines = [
    //    "babbage" => "text-babbage-001",
    //    "curies" => "text-curie-001",
    //    "ada" => "text-ada-001",
       "davinci" => "text-davinci-003"
    ];

    //Put your OpenAI API Token !
    private $token = process.env.OPEN_API_KEY;

    public function index(){

      //prompt or you can say user input
      $prompt = "What is Laravel";

      //choose model !
      //Davinci is the most powerful engine
      $engine = $this->engines['davinci'];

      //max tokens you want as an output
      //1 token is almost 0.75 word
      $maxTokens = 100;
        

       //Using Laravel HTTP
      $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $this->token"
        ])->post("https://api.openai.com/v1/engines/$engine/completions", [
            'prompt' => $prompt,
            "temperature" => 0.7,
            "max_tokens" => $maxTokens,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
        ]);

     //Now check if the request was successful or not !
     //After checking print result !

      if($response->failed()){
            return "Request Failed !";
      }
      else{

          //OpenAI API result
          return $response['choices'][0]['text'];
      }
    
   }
}
