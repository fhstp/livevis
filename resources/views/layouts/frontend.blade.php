<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>c-tv Konferenz 2017</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" type="text/css" media="screen, projection">
</head>

<body>

    <div class="mainHeader">
        <div class="row">
            <div class="col-md-3 col-md-offset-3 col-sm-5 col-sm-offset-2  col-xs-12 col-xs-offset-0 align_center">
                <a href="https://ctvkonferenz.fhstp.ac.at">
                    <img src="{{ URL::asset('images/banner_header.png') }}" alt="ctv banner">
                </a>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-2 col-xs-10 col-xs-offset-1">
                <h1>@yield('title')</h1>
            </div>
        </div>

        @yield('body')
    </div>

    <div class="row" style="margin-bottom: 30px;">
      <div class="col-md-2 col-md-offset-3 col-sm-4 col-sm-offset-2 col-xs-7 col-xs-offset-1">
          <img src="{{ URL::asset('images/ctv2017Logo.svg') }}" style="width:50px; display: inline;vertical-align: middle; margin-right:10px; " alt="ctv logo" /> <span style="padding-top: 50px;">ct-v Konferenz 2017</span>
      </div>
            <div class="col-md-4 col-md-offset-2 col-sm-4 col-sm-offset-1  col-xs-7 col-xs-offset-4">
                <h5 style="margin-top:20px;"> powered by IC\M/T, FH St. Pölten </h5>
            </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('js/main.js') }}"></script>
    @yield('scripts')

</body>

</html>
