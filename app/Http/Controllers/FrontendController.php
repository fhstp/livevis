<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Question;

use Cookie;

class FrontendController extends Controller
{
    public function index()
    {
      $categories = Category::all();
      return view('frontend.index', compact('categories'));
    }

    public function showQuestion(Category $category)
    {
      $activeQuestion = $category->questions()->where(['active' => 1])->first();

      if(!is_null($activeQuestion))
        $voted = request()->cookie('votedFor:'.$activeQuestion->id);
      else
        $voted = 0;

      return view('frontend.showQuestion', compact('category', 'activeQuestion', 'voted'));
    }

    public function vote(Question $question)
    {
      $vote = $question->votes()->create([
        'answer_id' => request('selectedAnswer')
      ]);

      $cookie = Cookie::make('votedFor:'.$question->id, $vote->answer_id, 60);

      return back()->withCookie($cookie); //->cookie('votedFor:'.$question->id, $vote->id, 60);
    }

    public function ajaxHandler(Category $category)
    {
      $activeQuestion = $category->questions()->where(['active' => 1])->first();

      $id = 0;

      if(!is_null($activeQuestion))
        $id = $activeQuestion->id;

      return $id;
    }
}
