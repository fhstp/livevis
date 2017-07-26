@extends('layouts.backend')

@section('content')

      <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <h2> Create a new Category</h2>
            <div class="panel panel-default" style="padding: 20px">
              <form method="POST" action="/categories">
                {{ csrf_field() }}

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Name of the category">
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
              </form>
            </div>
          </div>
      </div>
@endsection
