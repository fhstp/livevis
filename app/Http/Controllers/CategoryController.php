<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Question;

class CategoryController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show(Category $category)
  {
    $questions = $category->questions()->get();
    return view('backend.categories.show', compact('category', 'questions'));
  }

  public function edit(Category $category)
  {
    return view('backend.categories.edit', compact('category'));
  }

  public function update(Category $category)
  {
    $this->validate(request(), [
        'name' => 'required',
    ]);

    $category->update(request(['name']));

    return redirect('/backend');
  }

  public function destroy(Category $category)
  {
    $category->remove();
    return redirect('/backend')->with('success',"Category successfully deleted!");
  }

  public function create()
  {
    return view('backend.categories.create');
  }

  public function store()
  {
    $this->validate(request(), [
        'name' => 'required',
    ]);

    Category::create(request(['name']));

    return redirect('/backend')->with('success',"Category successfully created!");;
  }
}
