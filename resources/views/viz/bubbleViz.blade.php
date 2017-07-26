<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ctv-Konferenz 2017 | VIZ</title>

    <link rel="stylesheet" href="{{ URL::asset('css/reset.css') }}" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="{{ URL::asset('css/base.css') }}" type="text/css" media="screen, projection">
</head>
<body style="background: black;">

<!-- required by ajaxhandler. to get the riqht data for current question -->
<input type="hidden" id="question_id" value="{{ $question->id }}">


<!-- Full width container, spanning the entire width of your viewport -->
<div class="bubbleContainer">

    <div id="vis"></div>

    <div id="keyword">
        <h1 id="keywordText"></h1>
    </div>

</div>

<!-- D3 -->
<script src="//d3js.org/d3.v3.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="{{ URL::asset('js/bubbleChart.js') }}"></script>
<script>
    $( document ).keyup(function(e) {

        if (e.keyCode == 8) {
            window.location = "/vizControl";
        }
    });
</script>
</body>
</html>
