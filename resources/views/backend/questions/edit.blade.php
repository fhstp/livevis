@extends('layouts.backend')

@section('content')
<div class="container">
      <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <h2>Edit category</h2>
            <div class="panel panel-default" style="padding: 20px">
              <form method="POST" action="/categories/{{ $category->id }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" value="{{ $category->name }}" required>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
              </form>
            </div>
          </div>
      </div>
</div>
@endsection
