@extends('layouts.backend')

@section('content')

      <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <h2> Create a new Question</h2>
            <div class="panel panel-default" style="padding: 20px">
              <form method="POST" action="/categories/{{$category->id}}/questions">
                {{ csrf_field() }}

                <div class="form-group">
                  <label for="question">Text</label>
                  <input type="text" name="question" class="form-control" id="question" placeholder="Text of the question">
                </div>

                <div class="form-group">
                  <label for="keyword">Keyword</label>
                  <input type="text" name="keyword" class="form-control" id="keyword" placeholder="Keyword for the question">
                </div>

                <hr />
                <h3>Answer Options</h3>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><input type="checkbox" onclick="activateInput(this)" name="questionCheckbox" value="questionText1"> Answer 1:</div>
                    <input type="text" class="form-control" name="questionText1" id="questionText1" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><input type="checkbox" onclick="activateInput(this)" name="questionCheckbox" value="questionText2"> Answer 2:</div>
                    <input type="text" class="form-control" name="questionText2" id="questionText2" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><input type="checkbox" onclick="activateInput(this)" name="questionCheckbox" value="questionText3"> Answer 3:</div>
                    <input type="text" class="form-control" name="questionText3" id="questionText3" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><input type="checkbox" onclick="activateInput(this)" name="questionCheckbox" value="questionText4"> Answer 4:</div>
                    <input type="text" class="form-control" name="questionText4" id="questionText4" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><input type="checkbox" onclick="activateInput(this)" name="questionCheckbox" value="questionText5"> Answer 5:</div>
                    <input type="text" class="form-control" name="questionText5" id="questionText5" readonly>
                  </div>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
              </form>
            </div>
          </div>
      </div>
@endsection

@section('scripts')

  <script src="{{ asset('js/checkbox.js') }}"></script>

@endsection
