<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ArticleGenerator extends Controller
{
    //// app/Http/Controllers/ArticleGenerator.php

public function index(Request $input)
{
    if ($input->question == null) {
        return redirect('/write');

    }

    $question = $input->question;
    $openapi = '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'; 
    $client = OpenAI::client($openapi);

    // exit();

    // $client = OpenAI::client(config('app.openai_api_key'));
    
    $result = $client->completions()->create([
        "model" => "text-davinci-003",
        "temperature" => 0.7,
        "top_p" => 1,
        "frequency_penalty" => 0,
        "presence_penalty" => 0,
        'max_tokens' => 600,
        'prompt' => sprintf('Write an answer about: %s', $question),
    ]);

    $content = trim($result['choices'][0]['text']);


    return view('write', compact('question', 'content'));

    $user = Auth::user()->id;
    // DB::insert('insert into models (user_id, question, answer) values (?, ?, ?)', [$user, $question, $content]);
    \DB::table('models')->insert(array ('user_id' => '$user',
                'question' => '$question',
                'answer' => '$content',
    ));
}

}
