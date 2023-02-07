<?php 
use OpenAI\Laravel\Facades\OpenAI;
// $openapi = env('OPEN_API_KEY'); 
// $client = OpenAI::client($openapi);

$data = session()->all();
print_r($data);
// $body = print_r($_REQUEST, true);
if(isset($_REQUEST))
{
  print_r($_REQUEST);
  
}
?>
Welcome!

 <!-- <div class="container">

    <div class="chatbot-container">
    <div class="chatbot-header">
      <h2>What can we help you with?</h2>
    </div>
    <div class="chatbot-content">

      <form class="chatbot-form">
        <textarea id="chatbot-input" rows="4" cols="50" required></textarea><br />
        <button class="btn btn-primary" type="submit">Get Answer</button>
      </form>
    </div>
    <div class="chatbot-message-container">
      </div>
  </div>

<script>
const chatContainer = document.querySelector(".chatbot-message-container");
const form = document.querySelector(".chatbot-form");

form.addEventListener("submit", (event) => {
  event.preventDefault();
  const input = document.querySelector("#chatbot-input");
  const userMessage = input.value;
  input.value = "";
  // Call the OpenAI API to generate a response
  fetch(`https://api.openai.com/v1/completions`, {
    method: "POST",
    headers: {
    "Content-Type": "application/json",
    "Authorization":`Bearer `
    },
    body: JSON.stringify({
      model: "text-davinci-003",
      prompt: userMessage,
      temperature: 0.7,
      max_tokens: 256,
      top_p: 1,
      frequency_penalty: 0,
      presence_penalty: 0
    }),
    })
  .then(response => response.json())
  .then(data => {
    const chatbotMessage = data.choices[0].text;
    const messageContainer = document.createElement("div");
    messageContainer.innerHTML = `<div class="chatbot-message"> ${chatbotMessage} </div>`;
    chatContainer.appendChild(messageContainer);
    });
  });
</script>

  </div> -->

  <?php


// use Symfony\Component\HttpClient\Psr18Client;
// use \Tectalic\OpenAi\Manager;

// $openai = new \Tectalic\OpenAi\Manager('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');
// $openai = \Tectalic\OpenAi\Manager::build(new \GuzzleHttp\Client(), new \Tectalic\OpenAi\Authentication(getenv('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')));

// $client = OpenAI::client('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');


// check if user is logged in and has an active subscription
session_start();
// if (!isset($_SESSION['user']) || !check_subscription($_SESSION['user'])) {
//     // redirect to login page
//     header('Location: login.php');
//     exit;
// }

//check if user is logged in
// if (!isset($_SESSION['user'])) {
//     // redirect to login page
//     header('Location: login.php?message=login');
//     exit;
// } else {
//     $user = $_SESSION['user'];
//     $email = $user['email'];
// }

?>

<form action="" method="post">
    <label for="question">What question do you need help with?</label><br />
    <textarea name="question" id="question" rows="4" cols="50" required></textarea><br />
    <input type="submit" value="Submit">
</form>

<?php
if (isset($_POST['question'])) {

    $question = $_POST['question'];
    $model = 'text-davinci-003'; // GPT-3 model to use

// $query = "SELECT * FROM users WHERE email = '$email'";
//     $result = mysqli_query($conn, $query);
//     $user = mysqli_fetch_assoc($result);
//     $userId = $user['id'];

    $question = htmlspecialchars($question);

    // $query = "SELECT id,model,answer FROM models WHERE user_id = '$userId' and model = '$question'";
    // $result = mysqli_query($conn, $query);
    // $qa = mysqli_fetch_assoc($result);
    // print_r($qa);
    // if(is_null($qa)) {
    //     $qaId = '';
    //     $qaModel = '';
    //     $qaAnswer = '';
    //     // echo "Id and Model are null";
    //     // exit();
    // } else {
    //     $qaId = $qa['id'];
    //     $qaModel = $qa['model'];
    //     $qaAnswer = $qa['answer'];
    // }
    // echo $qaId;
    // echo $qaModel;
    // if ($qa['model']) {
    //     echo "You previously asked this question.";
    //        exit();
    // } else {

    // if (($qaModel != $question)) {

    // $query = "SELECT id FROM models WHERE user_id = '$userId' and model = '$question'";
    // $result = mysqli_query($conn, $query);
    // $models = mysqli_fetch_assoc($result);
    // $modelId = $models['id'];
    // $answerId = $models['answer'];


    // $sqlQ = "INSERT INTO models (user_id, model) VALUES (?,?)";
    // $stmt = $conn->prepare($sqlQ);
    // $stmt->bind_param("is", $user['id'], $question);
    // $insertUser = $stmt->execute();


    $result = $client->completions()->create([
        'prompt' => $question,
        'max_tokens' => 1024,
        // 'stop' => '.',
        'temperature' => 0.6,
        'top_p' => 1.0,
        'frequency_penalty' => 0.5,
        'presence_penalty' => 0,
        'model' => $model,
        'prompt' => $question,

    ]);


    // echo  // an open-source, widely-used, server-side scripting language.
    $answer = $result['choices'][0]['text'];

    // $sqlQ = "UPDATE models SET answer = (?) WHERE id = '$modelId')";
    // echo $sqlQ;
    // $stmt = $conn->prepare($sqlQ);
    // $stmt->bind_param("s", $answer);
    // $updateAnswer = $stmt->execute();


    // $sqlQ = "INSERT INTO models (user_id, model, answer) VALUES (?,?,?)";
    // $stmt = $conn->prepare($sqlQ);
    // $stmt->bind_param("iss", $user['id'], $question, $answer);
    // $insertUser = $stmt->execute();
    // $userId = $user['id'];

    echo "Your question: " . $question . "<br /><br />";
    echo "Answer: " . $answer .".";

    // } else {
    //     echo "You previously asked this question.";
    //     exit();
    // }
}

function check_subscription($user_id) {
    // check if user has an active subscription in the database
    // return true if active, false if not
}

?>