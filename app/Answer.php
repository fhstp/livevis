<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vote;
use Question;

class Answer extends Model
{
    protected $fillable = ['value'];

    public function question()
    {
      return $this->belongsTo('Question');
    }

    public function votes()
    {
      return $this->hasMany('Vote');
    }
}
