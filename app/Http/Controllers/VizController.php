<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Question;

class VizController extends Controller
{
    public function show()
    {
      $categories = Category::all();

      return view('viz.show', compact('categories'));
    }

    public function visualize(Question $question)
    {
      return view('viz.bubbleViz', compact('question'));
    }

    public function ajaxHandler(Question $question){
        $votings = $question->loadResultByQuestionId();
        $keyword = $question->keyword;

        $result = array($keyword, $votings);
        return $result;
    }
}
