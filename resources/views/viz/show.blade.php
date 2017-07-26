<!-- Link to Masterlayout -->
@extends('layouts.frontend')

@section('title')
    Visualization Control Center
    @yield('title')
@endsection

<!-- Replace Body -->
@section('body')
  @foreach($categories as $category)
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>{{ $category->name }}</h3>
            <ul style="margin-left: 50px;">
              @foreach($category->questions as $question)
                <li><a href="/bubbleViz/{{$question->id}}">{{ $question->question }}</a></li>
              @endforeach
            </ul>
            <hr />
        </div>
    </div>

  @endforeach

@endsection
