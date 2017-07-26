@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-2 col-md-offset-9">
          <a href="/categories/create"><button type="submit" class="btn btn-success">Create new Category</button></a>
        </div>
      </div>

      <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <h1>Categories</h1>
            <div class="panel panel-default" style="padding:20px;">
              <table class="table" style="width:100%:">
                <thead>
                  <tr><th>Name</th><th>Functions</th></tr>
                </thead>
                @if(count($categories))
                <tbody>
                  @foreach($categories as $category)
                    <tr>
                      <td><a href="/categories/{{$category->id}}" style="font-size:1.2em; font-weight:bold;"> {{$category->name}} </a></td>
                      <td>
                        <a href="/categories/{{$category->id}}/edit" style="float:left; margin-right: 10px;"><button type="button" class="btn btn-primary">Edit</button></a>
                        <form method="POST" action="/categories/{{$category->id}}">
                          {{ method_field('DELETE') }}
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                @endif
              </table>
            </div>
          </div>
        </div>
@endsection
