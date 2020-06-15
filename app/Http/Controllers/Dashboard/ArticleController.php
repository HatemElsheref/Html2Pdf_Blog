<?php

namespace App\Http\Controllers\Dashboard;

use App\Author;
use App\Department;
use App\Http\Controllers\Controller;
use App\NewsPaper;
use App\Tag;
use App\Jobs\GenerateArticlesPdf;
use Illuminate\Support\Carbon;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\Facades\Pdf as hatem;

use App\Article;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('authorized:read_articles')->only(['index','show']);
        $this->middleware('authorized:create_articles')->only(['create','store','upload','getDepartments']);
        $this->middleware('authorized:update_articles')->only(['edit','update']);
        $this->middleware('authorized:delete_articles')->only('destroy');
    }
    public function index(Request $request)
    {

        $articles=Article::with('author','tags','department','department.newspaper')->where(function ($query) use($request){

            return $query->when($request->search,function ($q) use ($request){

                return $q->where('title','like','%'.$request->search.'%');
            });
//        })->orderBy('created_at','desc')->get();
        })->orderBy('created_at','desc')->latest()->paginate(10);

        return view('dashboard.articles.index',compact('articles'));

    }
    public function create()
    {
        $newspapers=NewsPaper::with('departments')->get();
        $tags=Tag::all();
        $authors=Author::all();
        if (count($newspapers)==0){
            toast(' يجب اضافه جريده اولا ','info')->position('top-start');
            return redirect()->route('newspapers.create');
        }
        return view('dashboard.articles.create',['tags'=>$tags,'newspapers'=>$newspapers,'authors'=>$authors]);
    }
    public function store(Request $request){

        $request->validate([
            'title'=>'required|string|max:191',
            'subtitle' => 'required|string|max:191',
            'description' => 'required|string',
            'content' => 'required|string',
            'department_id' => 'required|numeric',
            'tags' => 'array',
        ],[
            'title.required'=>'العنوان الرئيسي مطلوب',
            'title.string'=>'العنوان الرئيسي يجب ان يكون نص واقل من 191 حرف',
            'title.max'=>'العنوان الرئيسي يجب ان يكون نص واقل من 191 حرف',
            'subtitle.required'=>'العنوان الفرعى مطلوب',
            'subtitle.string'=>'العنوان الفرعى يجب ان يكون نص واقل من 191 حرف',
            'subtitle.max'=>'العنوان الفرعى يجب ان يكون نص واقل من 191 حرف',
            'description.required'=>' الوصف مطلوب',
            'description.string'=>'الوصف  يجب ان يكون نص',
            'content.required'=>' المحتوى مطلوب',
            'content.string'=>'المحتوى  يجب ان يكون نص',
            'department_id.required'=>'القسم مطلوب',
            'department_id.numeric'=>'القسم يجب ان يكون بالرقم التعريفى فقط'  ,
            'tags.array'=>'الكلمات التعريفية يجب ان تكون على شكل مصفوفة'  ,

        ]);

        $department=Department::find($request->department_id);
        if (!$department){
            toast('فشلت العمليه جريده او قسم  غير معروفه مسبقا','error')->position('top-start');
            return redirect(route('departments.index'));
        }
        $validated_data=$request->all();
        $validated_data['user_id']=auth()->user()->id;
        $article=Article::create($validated_data);

        $article->tags()->attach($request->tags);
        if ($article){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('articles.index'));
    }
//    public function show(Article $article){
    public function show(Request $request){

        $newspaper=NewsPaper::all();
        $departments=Department::all();
        $authors=Author::all();
        $articles=Article::with('author','tags','department','department.newspaper')->where(function ($query) use($request){

            return $query->when($request->filter,function ($q) use ($request){
                if ($request->has('newspaper_id')){
                    if ($request->has('department_id') and $request->department_id >0) {
                        if ($request->has('author_id')){
                            return $q->where('department_id','=',$request->department_id)
                                ->Where('author_id','=',$request->author_id);
                        }   else{
                            return $q->where('department_id','=',$request->department_id);
                        }
                    } else{
                        if ($request->has('author_id')){
                            $departments=NewsPaper::with('departments')->find($request->newspaper_id);
                            if ($departments){
                                $departments=$departments->departments->pluck('id')->toArray();
                                return $q->whereIn('department_id',$departments)
                                    ->where('author_id',$request->author_id);
                            }   else{
                                return $q;
                            }
                        }else{
                                  $departments=NewsPaper::with('departments')->find($request->newspaper_id);
                                  if ($departments){
                                      $departments=$departments->departments->pluck('id')->toArray();
                                      return $q->whereIn('department_id',$departments);
                                  }   else{
                                        return $q;
                                  }
                        }
                    }
                } else{
                    if ($request->has('author_id')){
                        return $q->where('author_id','=',$request->author_id);
                    }   else{

                    }
                    return $q;
                }

            });
        })->orderBy('created_at','desc')->latest()->paginate(10);

        return view('dashboard.articles.show',compact('articles'))
            ->with('newspapers',$newspaper)
            ->with('departments',$departments)
            ->with('authors',$authors);
    }
    public function edit($id){
        $article=Article::with('department','tags','department.newspaper')->find($id);
        $newspapers=NewsPaper::with('departments')->get();
        $tags=Tag::all();
        $authors=Author::all();
        $articleTags=$article->tags->pluck('id')->toArray();

        return view('dashboard.articles.edit',['tags'=>$tags,'newspapers'=>$newspapers,'authors'=>$authors,'article'=>$article])
            ->with('articleTags',$articleTags);

    }
    public function update(Request $request,Article $article){

        $request->validate([
            'title'=>'required|string|max:191',
            'subtitle' => 'required|string|max:191',
            'description' => 'required|string',
            'content' => 'required|string',
            'department_id' => 'required|numeric',
            'tags' => 'array',
        ],[
            'title.required'=>'العنوان الرئيسي مطلوب',
            'title.string'=>'العنوان الرئيسي يجب ان يكون نص واقل من 191 حرف',
            'title.max'=>'العنوان الرئيسي يجب ان يكون نص واقل من 191 حرف',
            'subtitle.required'=>'العنوان الفرعى مطلوب',
            'subtitle.string'=>'العنوان الفرعى يجب ان يكون نص واقل من 191 حرف',
            'subtitle.max'=>'العنوان الفرعى يجب ان يكون نص واقل من 191 حرف',
            'description.required'=>' الوصف مطلوب',
            'description.string'=>'الوصف  يجب ان يكون نص',
            'content.required'=>' المحتوى مطلوب',
            'content.string'=>'المحتوى  يجب ان يكون نص',
            'department_id.required'=>'القسم مطلوب',
            'department_id.numeric'=>'القسم يجب ان يكون بالرقم التعريفى فقط'  ,
            'tags.array'=>'الكلمات التعريفية يجب ان تكون على شكل مصفوفة'  ,

        ]);

        $department=Department::find($request->department_id);
        if (!$department){
            toast('فشلت العمليه جريده او قسم  غير معروفه مسبقا','error')->position('top-start');
            return redirect()->back();
        }
        $validated_data=$request->all();
        $validated_data['user_id']=auth()->user()->id;
        $article->update($validated_data);

        if ($request->has('tags'))
        $article->tags()->sync($request->tags);
        else
         $article->tags()->sync(null);
        if ($article){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('articles.index'));
    }
    public function upload(Request $request){
        $srart="__starting__article__";
        $request->file('file')->storeAs('public/articles',$request->file('file')->hashName());
        $fileNameToStore=$request->file('file')->hashName();

        return json_encode(['location' => url('storage/articles/'.$fileNameToStore)]);
        /*
            $photo_path='public/articles';
            $request->file('name')->storeAs($photo_path,$request->file('name')->hashName()) ;
            $imgpath= url('/storage/articles/'.$request->file('name')->hashName());
            return response()->json_encode(['location' => $imgpath]);  */
    }
    public function getDepartments(Request $request){


        if ($request->ajax()){
            $newspaper=NewsPaper::find($request->id);
            if ($newspaper){
                return $newspaper->departments;
            }
        }
    }
    public function destroy(Article $article)
    {
        if (!$article){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('articles.index'));
        }
        $article->delete();
        toast('عمليه ناجحة','success')->position('top-start');
        return redirect(route('articles.index'));
    }
    public function pdf(Request $request){
        $articles=Article::find( $request->articles) ;
        $html = view('pdf', compact('articles'))->render();
        $pdf=new Dompdf();
        $pdf->loadHTML($html);
//        $pdf->render();
//        $pdf->stream(Carbon::now()->format('Y-m-d_h-i-s').'.pdf');

//        dd($pdf->outputHtml()) ;
        $response=response()->make($pdf->outputHtml(),200);
        $response->header("contentType","application/pdf");
        $response->header("contentDisposition","attachment;filename=screen-shot.pdf");
        return $response;


        /*
        $dompdf=new Dompdf(['enable_remote'=>true]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
        $dompdf->stream('test.pdf',['Attachment'=>false]);
           */
        /*
//       $pdf=PDF::loadHTML($html);
        $pdf = PDF::loadHTML($html);
        return $pdf->download('itsolutionstuff.pdf');

                 /*
                                                      GenerateArticlesPdf::dispatch($html);

        ini_set('max_execution_time',20000);
//        $pdf = PDF::loadView('pdf', compact('articles'));
        $pdf = PDF::loadHTML($html);

        return $pdf->download('itsolutionstuff.pdf');

        $article = PDF1::generatePdf($html);





        define('INVOICE_DIR', public_path('uploads/invoices'));



        $pdf=new Dompdf();
        $pdf->loadHTML($html);
        if (!is_dir(INVOICE_DIR)) {
            mkdir(INVOICE_DIR, 0755, true);
        }
        $outputName = Str::random(10);
        $pdfPath = INVOICE_DIR.'/'.$outputName.'.pdf';


        File::put($pdfPath, $pdf->outputHtml());

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="'.'filename.pdf'.'"',
        ];

        return response()->download($pdfPath, 'filename.pdf', $headers);
               */

                    /*
       $pdf= hatem::loadHTML($html);
       $pdf->download(time().'.pdf');
        return redirect()->route('articles.index');    **/
    }

}
