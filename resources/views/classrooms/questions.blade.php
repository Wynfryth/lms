<style>
     #countdown {
        font-size: 1em;
        color: #333;
    }
    /* Custom CSS for alphabetic list */
    .alphabetic-list {
        list-style-type: upper-alpha !important; /* Change to lower-alpha for lowercase letters */
    }
</style>
<x-app-layout>
    <x-slot name="header">
        {{-- <div id="countdown"></div> --}}
        <h6><a href="#" class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white hover:underline">{{$questions[0]->test_name}}</a></h6>
    </x-slot>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="grid grid-cols-4 gap-4">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg col-span-3">
                        <div id="question_point" class="text-right">
                        </div>
                        <div id="question_section">
                        </div>
                        <button type="button" id="lockAnswer" class="bg-green-400 hover:bg-green-300 text-xs font-bold text-white border rounded mt-2 p-2 w-full">Kunci</button>
                    </div>
                    <div>
                        <div class="p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                            <div class="border-b">
                                Sisa waktu:
                            </div>
                            <div class="text-2xl font-bold text-center">
                                <div id="countdown"></div>
                            </div>
                        </div>
                        <div class="p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                            <div class="border-b">
                                Nomor Soal:
                            </div>
                            <div class="text-sm text-center">
                                <div class="grid grid-cols-2 gap-4 my-2">
                                    <button id="prevQuestion" class="border rounded bg-white text-blue-700 hover:bg-blue-500 hover:text-white p-1 text-xs">< Prev</button>
                                    <button id="nextQuestion" class="border rounded bg-white text-blue-700 hover:bg-blue-500 hover:text-white p-1 text-xs">Next ></button>
                                </div>
                                <div class="flex flex-wrap m-2 gap-3">
                                    @forelse ($questions as $index => $question)
                                    <button type="button" class="flex-initial w-10 border p-1 rounded questionList" data-question="{{$index}}">{{$index+1}}</button>
                                    @empty

                                    @endforelse
                                </div>

                            </div>
                        </div>
                        <div class="p-4 sm:p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-3">
                            <div class="border-b">
                                Informasi:
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-2">
                                <button class="border rounded p-1 m-1 text-white bg-red-400">
                                    <div class="text-xs">KOSONG</div>
                                    <div class="font-semibold"><span id="unansweredQuestions">{{$questions->count()}}</span></div>
                                </button>
                                <button class="border rounded p-1 m-1 text-white bg-green-400">
                                    <div class="text-xs">DIJAWAB</div>
                                    <div class="font-semibold"><span id="answeredQuestions">0</span></div>
                                </button>
                                <button class="border rounded p-1 m-1 text-white bg-gray-400">
                                    <div class="text-xs">SOAL</div>
                                    <div class="font-semibold">{{$questions->count()}}</div>
                                </button>
                            </div>
                            <button id="submitTest" class="border rounded w-full bg-blue-500 hover:bg-blue-400 text-white py-1 mt-2 animate-bounce">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
var testComp = [];
var answeredQuestions = 0;
var unansweredQuestions = 0;
var questions = @json($questions);
$(document).ready(function() {
    var url = "{{route('testSessions.getCountdown', ':testScheduleId')}}";
    url = url.replace(':testScheduleId', "{{ $testScheduleId }}");
    var endTime;
    $.ajax({
        async: false,
        type: "GET",
        url: url,
        data: {
            _token: "{{csrf_token()}}"
        },
        // dataType: "JSON",
        success: function (response) {
            // console.log(response)
            endTime = response;
        }
    });
    // $.ajax({
    //     type: "GET",
    //     url: "url",
    //     data: "data",
    //     dataType: "dataType",
    //     success: function (response) {

    //     }
    // });
    var dateString = endTime; // Example date string
    // console.log(endTime)
    var endDate = new Date(dateString + ' GMT+0700'); // Convert to UTC Date object
    // console.log(endDate)

    function updateCountdown() {
        var now = new Date(); // Get the current date and time
        var timeRemaining = endDate - now; // Calculate the time remaining in milliseconds

        // Calculate days, hours, minutes, and seconds
        var seconds = Math.floor((timeRemaining / 1000) % 60);
        var minutes = Math.floor((timeRemaining / 1000 / 60) % 60);
        var hours = Math.floor((timeRemaining / (1000 * 60 * 60)) % 24);
        var days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));

        // Display the countdown
        // $('#countdown').text(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
        if(hours > 0){
            $('#countdown').text(hours+" : "+minutes + " : " + seconds);
        }else{
            $('#countdown').text(minutes + " : " + seconds);
        }

        // If the countdown is finished, display a message
        if (timeRemaining < 0) {
            clearInterval(countdownInterval);
            $('#countdown').text("Waktu Habis!");
            submitTest();
        }
    }
    for(var keys in questions){
        testComp.push({
            [questions[keys].question_id]: null
        });
    }

    // Update the countdown every second
    var countdownInterval = setInterval(updateCountdown, 1000);

    // Initial call to display the countdown immediately
    updateCountdown();


    // console.log(testComp);
    $('.questionList:first').trigger('click');
});

$(document).off('click', '.questionList').on('click', '.questionList', function(){
    questionButtonsColor();
    $(this).addClass('active bg-blue-600 hover:bg-blue-500 text-white');
    var questionIndex = $(this).data('question');

    // console.log(questions[questionIndex]);
    var question = questions[questionIndex];
    $('#question_point').html('('+question.points+' Poin)');
    var questionHtml = '<div class="font-bold">'+(parseInt(questionIndex)+1)+'. '+question.question+'</div>';

    var answers = question.answers.split('|');
    var answerIds = question.answer_ids.split('|');

    var answerHtml = '<div class="m-2"><ol class="alphabetic-list list-decimal pl-10">';
    for(var keys in answers){
        answerHtml += '<li class="my-3"><input type="radio" class="sr-only peer" id="'+answerIds[keys]+'" name="'+question.question_id+'" value="'+answerIds[keys]+'"><label class="p-1 cursor-pointer border rounded peer-checked:ring-green-500 peer-checked:ring-2 peer-checked:border-transparent" for="'+answerIds[keys]+'">'+answers[keys]+'</label></li>'
    }
    answerHtml += '</ol></div>';
    $('#question_section').html(questionHtml+answerHtml);

    var questionFromComp = testComp.find(function(item){ if(question.question_id in item){ return item }});
    if(questionFromComp[question.question_id] != null){ // berarti ada isinya
        $('#question_section').find('input[type="radio"][value="'+questionFromComp[question.question_id]+'"]').trigger('click');
        $('#question_section').find('input[type="radio"][value="'+questionFromComp[question.question_id]+'"]').next('label').addClass('bg-green-400 text-white');
    }
});

$(document).off('click', '#lockAnswer').on('click', '#lockAnswer', function(){
    var questionId = $(this).prev('#question_section').find('input[type="radio"]:checked').attr('name');
    var selectedAnswer = $(this).prev('#question_section').find('input[type="radio"]:checked').val();
    if(selectedAnswer != undefined){
        // set the answer to question compilation (testComp) where the question id match the questionId
        $(this).prev('#question_section').find('input[type="radio"]').next('label').removeClass('bg-green-400 text-white');
        $(this).prev('#question_section').find('input[type="radio"]:checked').next('label').addClass('bg-green-400 text-white');
        testComp.find(function(item){ if(questionId in item){ item[questionId] = selectedAnswer } });
        questionButtonsColor();
    }else{
        Swal.fire({
            icon: "warning",
            title: "Perhatian!",
            text: "Belum ada jawaban yang dipilih.",
            allowOutsideClick: false
        })
    }
});

$(document).off('click', '#prevQuestion').on('click', '#prevQuestion', function(){
    var prevObj = $('.questionList.active').prev('.questionList');
    if(prevObj.length > 0){
        prevObj.trigger('click')
    }
});

$(document).off('click', '#nextQuestion').on('click', '#nextQuestion', function(){
    var nextObj = $('.questionList.active').next('.questionList');
    if(nextObj.length > 0){
        nextObj.trigger('click')
    }
});

function questionButtonsColor(){
    $('.questionList').removeClass('active bg-blue-600 hover:bg-blue-500 text-white');
    var answeredQuestions = 0;
    var unansweredQuestions = 0;
    $.each(testComp, function (index, item) {
        if(item[Object.keys(item)[0]] != null){
            $('.questionList').eq(index).addClass('bg-green-400 hover:bg-green-300 text-white');
            answeredQuestions++;
        }else{
            unansweredQuestions++;
        }
    });
    $('#answeredQuestions').html(answeredQuestions);
    $('#unansweredQuestions').html(unansweredQuestions);
    if(answeredQuestions == testComp.length){
        $('#submitTest').removeClass('hidden');
    }else{
        $('#submitTest').addClass('hidden');
    }
}

$(document).off('click', '#submitTest').on('click', '#submitTest', function(){
    // console.log(testComp);
    Swal.fire({
        icon: "question",
        title: "Submit?",
        text: "Apakah Anda yakin untuk submit jawaban?",
        allowOutsideClick: false,
        showDenyButton: true,
        confirmButtonText: "Submit",
        denyButtonText: "Batal"
    })
    .then((feedback) => {
        if(feedback.isConfirmed){
            // submit the test
            $.ajax({
                type: "POST",
                url: "{{route('testSessions.submitTest')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    answers: testComp,
                    testScheduleId: "{{$testScheduleId}}"
                },
                dataType: "JSON",
                success: function (response) {
                    // console.log(response);
                    if(response.success){
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Jawaban Anda telah disimpan.",
                            allowOutsideClick: false
                        })
                        .then((feedback2)=>{
                            if(feedback2.isConfirmed){
                                var url = "{{route('testSessions.testResult', ['nip' => ':nip', 'studentTestId' => ':testScheduleId'])}}";
                                url = url.replace(':nip', "{{Auth::user()->nip}}");
                                url = url.replace(':testScheduleId', "{{$testScheduleId}}");
                                window.location.href = url;
                            }
                        })
                    }
                }
            });
        }
    })
})

function submitTest(){
    // console.log(testComp);
    $.ajax({
        async: false,
        type: "POST",
        url: "{{route('testSessions.submitTest')}}",
        data: {
            _token: "{{csrf_token()}}",
            answers: testComp,
            testScheduleId: "{{$testScheduleId}}"
        },
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            if(response.success){
                var url = "{{route('testSessions.testResult', ['nip' => ':nip', 'studentTestId' => ':testScheduleId'])}}";
                url = url.replace(':nip', "{{Auth::user()->nip}}");
                url = url.replace(':testScheduleId', "{{$testScheduleId}}");
                window.location.href = url;
            }
        }
    });
}
</script>
