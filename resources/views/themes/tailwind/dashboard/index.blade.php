@extends('theme::layouts.app')


@section('content')

<?php $data = session()->all();
// print_r($data);
$user = Auth::user()->id;

?>
	<div class="flex flex-col px-8 mx-auto my-6 lg:flex-row max-w-7xl xl:px-5">
	    <div class="flex flex-col justify-start flex-1 mb-5 overflow-hidden bg-white border rounded-lg lg:mr-3 lg:mb-0 border-gray-150">
	        <div class="flex flex-wrap items-center justify-between p-5 bg-white border-b border-gray-150 sm:flex-no-wrap">
				<div class="flex items-center justify-center w-12 h-12 mr-5 rounded-lg bg-wave-100">
					<svg class="w-6 h-6 text-wave-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
				</div>
				<div class="relative flex-1">
	                <h3 class="text-lg font-medium leading-6 text-gray-700">
	                    Welcome to your Dashboard, {{ Auth::user()->name }}. Your user ID is {{ Auth::user()->id }}.
	                </h3>
	                
				</div>

	        </div>
	        <div class="relative p-5">
	            <!-- <p class="text-base leading-loose text-gray-500">This is your application <a href="{{ route('wave.dashboard') }}" class="underline text-wave-500">dashboard</a>, you can customize this view inside of <code class="px-2 py-1 font-mono text-base font-medium text-gray-600 bg-gray-100 rounded-md">{{ theme_folder('/dashboard/index.blade.php') }}</code><br><br> (Themes are located inside the <code>resources/views/themes</code> folder)</p> -->

				<p class="text-lg leading-5 text-gray-500 mt">
	                    Below are your previous questions and answers:
	                </p><p>&nbsp;</p><hr /><br />
					<?php
					$questions = DB::table('models')->where('user_id', $user)->orderBy('created_at', 'desc')->get();
						if(count($questions) == 0)
						echo '<p class="text-sm leading-5 text-gray-500 mt">You haven\'t asked any questions, yet.</p>';
						
						foreach ($questions as $question)
						{
							
							echo '<p class="text-sm leading-5 text-gray-500 mt">Question: ' . $question->question . '<br /><br />';
							echo "Answer: " . $question->answer . '</p><br /><hr /><br';
							// var_dump($question->question, $question->answer);
							
						}
						
					?>
				

				<span class="inline-flex mt-5 rounded-md shadow-sm">
	                <a href="{{ url('write') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
	                   Click Here For Answers
	                </a>
				</span>
				
			</div>
		</div>
		<div class="flex flex-col justify-start flex-1 overflow-hidden bg-white border rounded-lg lg:ml-3 border-gray-150">
	        <div class="flex flex-wrap items-center justify-between p-5 bg-white border-b border-gray-150 sm:flex-no-wrap">
				<div class="flex items-center justify-center w-12 h-12 mr-5 rounded-lg bg-wave-100">
					<svg class="w-6 h-6 text-wave-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
				</div>
				<div class="relative flex-1">
	                <h3 class="text-lg font-medium leading-6 text-gray-700">
						Let's get you some answers!
	                </h3>
	                <p class="text-sm leading-5 text-gray-500 mt">
						Just ask your question below and we'll provide you an answer.
	                </p>
				</div>

	        </div>
	        <div class="relative p-5">
				
				<?php $openapi = env('OPEN_API_KEY'); ?>

				<div class="container">

					<div class="chatbot-container">
						<div class="chatbot-header">
						<h2 class="text-base leading-loose text-gray-500">What can we help you with?</h2>
						</div>
						<span class="inline-flex mt-5 rounded-md shadow-sm">
	                <a href="{{ url('write') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
	                   Click Here To Get Answers
	                </a>
				</span>
						<!-- <div class="chatbot-content">

						<form class="chatbot-form" action="/write/generate" method="post">
							<textarea id="chatbot-input" name="question" rows="4" cols="50" required></textarea><br />
							<button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50" type="submit">Get Answer</button>
						</form>
						</div>
						<div class="chatbot-message-container">
					</div> -->
				</div>

				<!-- <script>
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
					messageContainer.innerHTML = 
					`<div class="chatbot-message"><p class="text-base leading-loose text-gray-500"><br /><b>You asked:</b><br /> ${userMessage} <br/><br />
					<b>Answer:</b> <br />
					 ${chatbotMessage} </p></div>`;
					chatContainer.appendChild(messageContainer);
					});
				});
				</script> -->
				</div>
			</div>
	    </div>

	</div>

@endsection
