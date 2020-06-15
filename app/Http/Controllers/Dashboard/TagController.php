<?php

namespace App\Http\Controllers\Dashboard;

use App\Department;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
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

        $tags=Tag::where(function ($query) use($request){

            return $query->when($request->search,function ($q) use ($request){

                return $q->where('name','like','%'.$request->search.'%');
            });
        })->latest()->paginate(5);

        return view('dashboard.tags.index',compact('tags'));

    }
    public function create()
    {
        return view('dashboard.tags.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','max:191','unique:tags,name'],
        ],[
            'name.required'=>'الاسم مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
        ]);

        $validated_data=$request->all();
        $tag=Tag::create($validated_data);

        if ($tag){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('tags.index'));
    }
    public function edit(Tag $tag){
        if ($tag){
            return view('dashboard.tags.edit',compact('tag'));
        } else{
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('tags.index'));
        }
    }
    public function update(Request $request, Tag $tag)
    {
        if (!$tag){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('tags.index'));
        }

        $request->validate([
            'name'=>['required','string','max:191','unique:tags,name,'.$tag->id]
        ],[
            'name.required'=>'الاسم مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
        ]);

        $validated_data=$request->all();

        $tag->update($validated_data);


        if ($tag){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }


        return redirect(route('tags.index'));
    }
    public function destroy(Tag $tag)
    {
        if (!$tag){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('tags.index'));
        }
        $tag->delete();
        toast('عمليه ناجحة','success')->position('top-start');
        return redirect(route('tags.index'));
    }

}
