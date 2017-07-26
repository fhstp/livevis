<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Question extends Model
{
  protected $fillable = ['question', 'keyword', 'active'];

  public function category()
  {
    return $this->belongsTo('App\Category');
  }

  public function answers()
  {
    return $this->hasMany('App\Answer');
  }

  public function votes()
  {
    return $this->hasMany('App\Vote');
  }

  public function activate()
  {
    $this->update(['active' => 1]);
  }

  public function deactivate()
  {
    $this->update(['active' => 0]);
  }

  public function clearVotes()
  {
    $this->votes()->delete();
  }

  public function loadResultByQuestionId(){
      $qID = $this->id;

      $qCount = DB::select('SELECT value, id
        FROM `answers`
        WHERE answers.`question_id` = ?', array($qID));

      $aCount = DB::select('SELECT Count(*) AS votes, value, answer_id
        FROM `votes`
        JOIN answers ON answers.id = votes.answer_id
        WHERE answers.`question_id` = ?
        GROUP BY `answer_id`
        ORDER BY answer_id', array($qID));

      $sumVotes = 0;

      foreach($aCount as $aC){
          $sumVotes += $aC->votes;
      }

      $result = [];

      foreach($qCount AS $i => $qC){
          $qC->votes = 0;
          $qC->votesPercent = number_format(0).'%';
          foreach($aCount as $aC){
              if($qC->id == $aC->answer_id){
                  $qC->votes = $aC->votes;


                      $qC->votesPercent = number_format(($aC->votes / $sumVotes)*100,0).'%';
              }
          }
          $result[$i] = $qC;
      }

      return $result;
  }
}
