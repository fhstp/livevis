<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Category;

class QuestionController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function create(Category $category)
    {
      return view('backend.questions.create', compact('category'));
    }

    public function store(Category $category)
    {
      $this->validate(request(), [
          'question' => 'required',
          'keyword'  => 'required'
      ]);

      $question = $category->questions()->create(request(['question', 'keyword']));

      if(!is_null(request('questionText1')))
        $question->answers()->create(['value' => request('questionText1')]);

      if(!is_null(request('questionText2')))
        $question->answers()->create(['value' => request('questionText2')]);

      if(!is_null(request('questionText3')))
        $question->answers()->create(['value' => request('questionText3')]);

      if(!is_null(request('questionText4')))
        $question->answers()->create(['value' => request('questionText4')]);

      if(!is_null(request('questionText5')))
        $question->answers()->create(['value' => request('questionText5')]);

      return redirect('/categories/'.$category->id)->with('success',"Question successfully created!");;
    }

    public function destroy(Category $category, Question $question)
    {
      $question->votes()->delete();
      $question->answers()->delete();
      $question->delete();
      return redirect('/categories/'.$category->id)->with('success',"Question successfully deleted!");
    }

    public function activate(Category $category, Question $question)
    {
      $category->questions()->where('active', 1)->update(['active' => 0]);
      $question->activate();

      return redirect('/categories/'.$category->id)->with('success',"Question activated!");
    }

    public function deactivate(Category $category, Question $question)
    {
      $question->deactivate();

      return redirect('/categories/'.$category->id)->with('success',"Question deactivated!");
    }

    public function clearVotes(Category $category, Question $question)
    {
      $question->clearVotes();

      return back()->with('success',"Votes cleared!");
    }
}
