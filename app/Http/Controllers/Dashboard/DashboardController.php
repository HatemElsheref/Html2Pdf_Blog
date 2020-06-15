<?php

namespace App\Http\Controllers\Dashboard;
use App\Article;
use App\Author;
use App\Tag;
use App\User;
use App\Department;
use App\Http\Controllers\Controller;
use App\NewsPaper;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $articles=Article::with(['tags','department','department.newspaper','author'])->get();
        $newspaper=NewsPaper::all();
        $departments=Department::all();
        $authors=Author::all();
        $tags=Tag::all();
        $users=User::all();
        return view('dashboard._site',compact('articles'))
            ->with('newspapers',$newspaper)
            ->with('departments',$departments)
            ->with('authors',$authors)
            ->with('tags',$tags)
            ->with('users',$users);
    }
}
