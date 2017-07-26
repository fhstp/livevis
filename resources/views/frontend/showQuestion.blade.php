<!-- Link to Masterlayout -->
@extends('layouts.frontend')

@section('title')
    {{ $category->name }}
    @yield('title')
@endsection

<!-- Replace Body -->
@section('body')

    @if(!is_null($activeQuestion))

        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">
            <form method="POST" action="/questionnaire/{{ $activeQuestion->id }}/vote">
              {{ csrf_field() }}

              <input type="hidden" id="category_id" value="{{ $category->id }}">
              <input type="hidden" id="question_id" value="{{ $activeQuestion->id }}">

              <div class="card">
                  <div class="card-block">
                      <div class="card-title">
                          <div class="row">
                              <div class="col-md-12 align_right">
                                  <a href="{{ URL::to('/') }}"><span class="glyphicon glyphicon-remove close-question" aria-hidden="true"></span></a>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12 headerText">
                                  <p>{{ $activeQuestion->question }}</p>
                              </div>
                          </div>
                      </div>
                      <div class="card-block">
                        <ul class="list-group">
                          @foreach($activeQuestion->answers as $index => $answer)

                            @if(is_null($voted))
                                <?php $hover = "_hover"; $isActiveClass = "";?>
                            @else
                                <?php
                                  $hover = "";

                                  if($answer->id == $voted)
                                    $isActiveClass = "isActive";

                                  else
                                    $isActiveClass = "";
                                ?>
                            @endif

                                <li class="list-group-item li_answer {{ $isActiveClass }} {{ $hover }}" id="answer{{ $index+1 }}">
                                    <div class="row">
                                        <div class="col-xs-1">
                                            <svg height="10" width="10">
                                                <circle class="radio-circle" cx="5" cy="5" r="4" stroke="black" stroke-width="2" fill="white" />
                                            </svg>
                                        </div>

                                        <div class="col-xs-10">
                                            <input type="radio" name="selectedAnswer" value="{{ $answer->id }}" required><p class="labelAnswer">{{ $answer->value }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if(is_null($voted))
                        <div class="align_right">
                          <button type="submit" class="btn btn-success">Abstimmen</button>
                        </div>
                        @endif
                      </form>
                    </div>
                </div>
                </div>
            </div>
        </div>

    @else

      <div class="row" style="margin:30px 0 50px 0">
          <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
              <div class="list-group text-center">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-12 align_right">
                                    <a href="{{ URL::to('/') }}"><span class="glyphicon glyphicon-remove close-question" aria-hidden="true"></span></a>
                                </div>
                            </div>
                            <div class="row" style="margin:30px 0 50px 0">
                                <div class="col-md-12 headerText">
                                    <h3>Bitte warten Sie bis eine Frage freigschaltet wird!</h3>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
              </div>
          </div>
      </div>

      <input type="hidden" id="category_id" value="{{ $category->id }}">
      <input type="hidden" id="question_id" value="0">

    @endif

@endsection

@section('scripts')

  <script src="{{ asset('js/questionHandler.js') }}"></script>

@endsection
