<?php

namespace App\Http\Controllers\Dashboard;

use App\NewsPaper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsPaperController extends Controller
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

        $newspaper=NewsPaper::where(function ($query) use($request){

            return $query->when($request->search,function ($q) use ($request){

                return $q->where('name','like','%'.$request->search.'%');
            });
        })->latest()->paginate(5);

        return view('dashboard.newspapers.index',compact('newspaper'));

    }

    public function create()
    {
        return view('dashboard.newspapers.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'name' => 'required|string|max:191|unique:news_papers,name',
            'photo' => 'image|mimes:jpg,png,jpeg',
        ],[
            'name.required'=>'الاسم مطلوب',
            'description.required'=>'الوصف مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'description.string'=>'الوصف يجب ان يكون نص    ',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
            'photo.image'=>'الصوره  يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->all();
        if ($request->hasFile('photo')){
            $photo_path='public/newspapers';
            $request->file('photo')->storeAs($photo_path,$request->file('photo')->hashName());
            $validated_data['photo']=$request->file('photo')->hashName();
        }else{
            $path='default-user.png';
            $validated_data['photo']=$path;
        }
        $author=NewsPaper::create($validated_data);

        if ($author){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('newspapers.index'));
    }
    public function edit(NewsPaper $newspaper){
        if ($newspaper){
            return view('dashboard.newspapers.edit',compact('newspaper'));
        } else{
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('newspapers.index'));
        }
    }
    public function update(Request $request, NewsPaper $newspaper)
    {
        if (!$newspaper){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('newspapers.index'));
        }

        $request->validate([
            'description' => 'required|string',
            'name' => 'required|string|max:191|unique:news_papers,name,'.$newspaper->id,
            'photo' => 'image|mimes:jpg,png,jpeg',
        ],[
            'name.required'=>'الاسم مطلوب',
            'description.required'=>'الوصف مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'description.string'=>'الوصف يجب ان يكون نص    ',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
            'photo.image'=>'الصوره  يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->all();
        if ($request->hasFile('photo')){
            $path='default-user.png';
            $photo_path='public/newspapers';
            if ($newspaper->photo!=$path) {
                Storage::disk('public')->delete('newspapers/'.$newspaper->photo);
            }
            $request->file('photo')->storeAs($photo_path,$request->file('photo')->hashName());
            $validated_data['photo']=$request->file('photo')->hashName();
        }else{
            $path='default-user.png';
            $validated_data['photo']=$path;
        }

        $newspaper->update($validated_data);


        if ($newspaper){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }


        return redirect(route('newspapers.index'));
    }
    public function destroy(NewsPaper $newspaper)
    {
        if (!$newspaper){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('newspapers.index'));
        }
        $path='default-user.png';
        if ($newspaper->photo!=$path) {
            Storage::disk('public')->delete('newspapers/'.$newspaper->photo);
        }
        $newspaper->departments()->delete();
        $newspaper->delete();
        toast('عمليه ناجحة','success')->position('top-start');
        return redirect(route('newspapers.index'));
    }

}
