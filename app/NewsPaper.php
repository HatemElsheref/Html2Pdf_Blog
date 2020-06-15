<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPaper extends Model
{
    protected $table='news_papers';
    protected $fillable=[
        'name','description','photo'
    ];
    public function departments(){
        return $this->hasMany('App\Department','news_paper_id','id');
    }
}
