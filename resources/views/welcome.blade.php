<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Newspaper;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Session;

class ExportController extends Controller
{
/**
* @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
* @throws \Illuminate\Auth\Access\AuthorizationException
*/
public function index()
{
$this->authorize('export');
$categories = Category::all();
return view('export', compact('categories'));
}

/**
* @param Request $request
* @return RedirectResponse
* @throws \Illuminate\Auth\Access\AuthorizationException
*/
public function export(Request $request): RedirectResponse
{
$this->authorize('export');
if ((int)$request->input('type') === 1) {
$this->exportArticles($request);
} else {
$this->exportNewspapers($request);
}
Input::flash();
Session::flash('msg', 'لا توجد نتائج لبحثك');
return back();
}

protected function exportArticles(Request $request)
{
$articles = Article::query();
$from = $request->input('from') ?? Carbon::now()->subDays(7)->format('Y-m-d');
$to = $request->input('to') ?? Carbon::now()->format('Y-m-d');
// $articles = $articles->whereBetween('created_at', [$from, $to]);
if ($request->input('q')) {
$articles = $articles->where('title', 'LIKE', '%' . $request->input('q') . '%');
}
if ($request->input('category')) {
$articles = $articles->whereIn('category_id', $request->input('category'));
}
$articles = $articles->get();
if ($articles->count()) {
$pdf = Pdf::loadView('prints.articles', compact('articles'));
return $pdf->download('export_articles_' . Carbon::now()->format('Y_m_d_H_m_i') . '.pdf');
}
}

protected function exportNewspapers(Request $request)
{
$newspapers = Newspaper::query();
if ($request->input('q')) {
$newspapers = $newspapers->where('title', 'LIKE', '%' . $request->input('q') . '%');
}
$newspapers = $newspapers->get();
if ($newspapers->count()) {
$pdf = Pdf::loadView('prints.newspapers', compact('newspapers'));
return $pdf->download('export_newspapers_' . Carbon::now()->format('Y_m_d_H_m_i') . '.pdf');
}
}
}
