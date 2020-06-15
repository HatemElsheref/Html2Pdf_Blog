<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected  $table='departments';
    protected $fillable=['name','news_paper_id'];

    public function newspaper(){
         return $this->belongsTo('App\NewsPaper','news_paper_id','id');
    }
}
