@if (\Session::has('success'))
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ \Session::get('success') }}
          </div>
      </div>
  </div>
@endif
