<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = ['name'];


  public function questions()
  {
    return $this->hasMany('App\Question');
  }

  public function remove()
  {
    $questions = $this->questions()->get();

    foreach($questions as $question)
    {
      $question->votes()->delete();
      $question->answers()->delete();
    }

    $this->questions()->delete();
    $this->delete();
  }
}
