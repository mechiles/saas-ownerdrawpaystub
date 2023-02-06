<?php $openapi = env('OPEN_API_KEY'); ?>
Welcome!

 <div class="container">

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
    "Authorization":`Bearer <?php echo($openapi); ?>`
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

  </div>