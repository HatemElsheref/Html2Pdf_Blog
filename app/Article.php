<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected  $table='articles';
    protected $fillable=[
        'title','subtitle','description','content','department_id','author_id','user_id'
    ];
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
    public function author(){
        return $this->belongsTo('App\Author');
    }
    public function department(){
        return $this->belongsTo('App\Department');
    }
}
