@extends('layouts.backend')

@section('content')
<div class="container">
      <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="padding: 20px">
              <h2 style="margin-bottom:30px; text-transform:uppercase;">Category: {{ $category->name }}</h2>

            <h3>Questions</h3>

            <div class="col-md-2 col-md-offset-9">
              <a href="/categories/{{ $category->id }}/questions/create"><button type="submit" class="btn btn-success">Create new Question</button></a>
            </div>

            <table class="table" style="width:100%:">
              <thead>
                <tr><th>Text</th><th>Keyword</th><th>Functions</th></tr>
              </thead>
              @if(count($questions))
              <tbody>
                @foreach($questions as $question)
                  <tr>
                    <td><b>{{$question->question}} <b></td>
                    <td><span> {{$question->keyword}} </span></td>
                    <td style="width:40%;">
                      @if($question->active)
                      <form method="POST" style="float:left; margin-right:20px;" action="/categories/{{$category->id}}/questions/{{$question->id}}/deactivate">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-warning">Deactivate</button>
                      </form>
                      @else
                      <form method="POST" style="float:left; margin-right:20px;" action="/categories/{{$category->id}}/questions/{{$question->id}}/activate">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Activate</button>
                      </form>
                      @endif

                      <form method="POST" style="float:left; margin-right:20px;" action="/categories/{{$category->id}}/questions/{{$question->id}}">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form>

                      <form method="POST" action="/categories/{{$category->id}}/questions/{{$question->id}}/clearVotes">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger">Clear Votes</button>
                      </form>

                    </td>
                  </tr>
                @endforeach
              </tbody>
              @endif
            </table>

            </div>

            <hr />
          </div>
      </div>
</div>
@endsection
