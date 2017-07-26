<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
  protected $fillable = ['question_id', 'answer_id'];

  public function question()
  {
    return $this->belongsTo('Question');
  }

  public function answer()
  {
    return $this->belongsTo('Answer');
  }
}
