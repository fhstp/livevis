<!-- Link to Masterlayout -->
@extends('layouts.frontend')


@section('title')
    Themenspezifischer Fragebogen
    @yield('title')
@endsection

<!-- Replace Body -->
@section('body')

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 headerText">
            <p>Jede Frage kann nur 1x beantwortet werden.</p>
            <p>Bitte klicken Sie auf die Kategorie, aus der Sie Fragen beantworten möchten: </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
            <div class="list-group">
              @foreach($categories as $category)
                  <a href="questionnaire/{{$category->id}}/questions" class="list-group-item">
                      <div class="row">
                          <div class="col-md-11 col-sm-11 col-xs-10">
                              <h4 class="list-group-item-heading">{{ $category->name }}</h4>
                          </div>
                          <div class="col-xs-1">
                              <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                          </div>
                      </div>
                  </a>
              @endforeach
            </div>
        </div>
    </div>
@endsection
