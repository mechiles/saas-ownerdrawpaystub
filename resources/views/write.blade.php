@extends('theme::layouts.app')

@section('content')


    <head>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Space+Grotesk:wght@400;600;700&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body {
                font-family: 'Space Grotesk', sans-serif;
            }
            .title:empty:before {
                content:attr(data-placeholder);
                color:gray
            }

        </style>

        <script src="https://unpkg.com/marked" defer></script>

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8 space-y-4 py-4">
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

                <div class="w-full rounded-md bg-white border-2 border-gray-600 p-4 min-h-[60px] h-full text-gray-600">
                    <form action="/write/generate" method="post" class="inline-flex gap-2 w-full">
                        @csrf
                        <input required name="question" class="w-full outline-none text-lg leading-5 text-gray-500 font-bold" placeholder="Type your question..." />
                        <button class="rounded-md bg-blue-500 items-center px-3 py-2 text-lg font-medium leading-4 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 text-white">Get Answer</button>
                    </form>
                </div>
                <div class="w-full rounded-md bg-white border-2 border-gray-600 p-4 min-h-[420px] h-full text-gray-600">
                    
                <?php if ($question != '') {
                    echo "Your question: $question<br /><hr /><br />";
                };
                ?>
                    <!-- <textarea class="min-h-[420px] h-full w-full outline-none" spellcheck="false">{{ $content }}</textarea> -->
                    <div class="chatbot-message-container">{{ $content }}
					</div>
                </div>
            </div>
        </div>
    </body>
     <?php
     $user = Auth::user()->id;
     if ($content != '') {
    // DB::insert('insert into models (user_id, question, answer) values (?, ?, ?)', [$user, $question, $content]);
    \DB::table('models')->insert(array ('user_id' => $user,
        'question' => $question,
        'answer' => $content,
    ));
}
    ?>
@endsection