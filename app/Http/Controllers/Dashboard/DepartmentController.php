<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Department;
use App\NewsPaper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{

    public function __construct()
    {

        $this->middleware('authorized:read_users')->only('index');
        $this->middleware('authorized:create_users')->only('create');
        $this->middleware('authorized:create_users')->only('store');
        $this->middleware('authorized:update_users')->only('edit');
        $this->middleware('authorized:update_users')->only('update');
        $this->middleware('authorized:delete_users')->only('destroy');
    }
    public function index(Request $request)
    {

        $departments=Department::with('newspaper')->where(function ($query) use($request){

            return $query->when($request->search,function ($q) use ($request){

                return $q->where('name','like','%'.$request->search.'%');
            });
        })->latest()->paginate(5);

        return view('dashboard.departments.index',compact('departments'));

    }

    public function create()
    {
        $newspapers=NewsPaper::all();
        if (count($newspapers)==0){
            toast(' يجب اضافه جريد اولا ','info')->position('top-start');
            return redirect()->route('newspapers.create');
        }
        return view('dashboard.departments.create',compact('newspapers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','max:191', Rule::unique('departments','name')->where('news_paper_id',$request->news_paper_id)],
            'news_paper_id' => 'required|numeric'
        ],[
            'name.required'=>'الاسم مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
            'news_paper_id.required'=>'الجريده مطلوبه',
            'news_paper_id.numeric'=>'الجريده مطلوبه فقط بالقرم التعريفى',
        ]);

        $News=NewsPaper::find($request->news_paper_id);
        if (!$News){
            toast('فشلت العمليه جريده غير معروفه مسبقا','error')->position('top-start');
            return redirect(route('departments.index'));
        }
        $validated_data=$request->all();
        $department=Department::create($validated_data);

        if ($department){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('departments.index'));
    }
    public function edit(Department $department){
        if ($department){
            return view('dashboard.departments.edit',compact('department'))->with('newspapers',NewsPaper::all());
        } else{
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('departments.index'));
        }
    }
    public function update(Request $request, Department $department)
    {
        if (!$department){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('departments.index'));
        }

        $request->validate([
            'name'=>['required','string','max:191', Rule::unique('departments','name')->where('news_paper_id',$request->news_paper_id)->ignore($department->id)],
            'news_paper_id' => 'required|numeric'
        ],[
            'name.required'=>'الاسم مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
            'news_paper_id.required'=>'الجريده مطلوبه',
            'news_paper_id.numeric'=>'الجريده مطلوبه فقط بالقرم التعريفى',
        ]);

        $validated_data=$request->all();

        $department->update($validated_data);


        if ($department){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }


        return redirect(route('departments.index'));
    }
    public function destroy(Department $department)
    {
        if (!$department){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('departments.index'));
        }
        $department->delete();
        toast('عمليه ناجحة','success')->position('top-start');
        return redirect(route('departments.index'));
    }

}
