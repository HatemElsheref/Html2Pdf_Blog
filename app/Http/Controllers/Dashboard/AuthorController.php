<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Author;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
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

        $authors=Author::where(function ($query) use($request){

            return $query->when($request->search,function ($q) use ($request){

                return $q->where('name','like','%'.$request->search.'%');
            });
        })->latest()->paginate(5);

        return view('dashboard.authors.index',compact('authors'));

    }

    public function create()
    {
        return view('dashboard.authors.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'name' => 'required|string|max:191|unique:authors,name',
            'photo' => 'image|mimes:jpg,png,jpeg',
        ],[
            'name.required'=>'الاسم مطلوب',
            'description.required'=>'الوصف مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'description.string'=>'الوصف يجب ان يكون نص    ',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
            'photo.image'=>'الصوره الشخصيه يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->all();
        if ($request->hasFile('photo')){
            $photo_path='public/authors';
            $request->file('photo')->storeAs($photo_path,$request->file('photo')->hashName());
            $validated_data['photo']=$request->file('photo')->hashName();
        }else{
            $path='default-user.png';
            $validated_data['photo']=$path;
        }
        $author=Author::create($validated_data);

        if ($author){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('authors.index'));
    }
    public function edit(Author $author){
        if ($author){
            return view('dashboard.authors.edit',compact('author'));
        } else{
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('authors.index'));
        }
    }
    public function update(Request $request, Author $author)
    {
        if (!$author){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('author.index'));
        }

        $request->validate([
            'description' => 'required|string',
            'name' => 'required|string|max:191|unique:authors,name,'.$author->id,
            'photo' => 'image|mimes:jpg,png,jpeg',
        ],[
            'name.required'=>'الاسم مطلوب',
            'description.required'=>'الوصف مطلوب',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'description.string'=>'الوصف يجب ان يكون نص    ',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.unique'=>'هذا الاسم  موجود بالفعل',
            'photo.image'=>'الصوره الشخصيه يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->all();
        if ($request->hasFile('photo')){
            $path='default-user.png';
            $photo_path='public/authors';
            if (!$author->photo==$path) {
                Storage::disk('public')->delete('authors/'.$author->photo);
            }
            $request->file('photo')->storeAs($photo_path,$request->file('photo')->hashName());
            $validated_data['photo']=$request->file('photo')->hashName();
        }else{
            $path='default-user.png';
            $validated_data['photo']=$path;
        }

        $author->update($validated_data);


        if ($author){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }


        return redirect(route('authors.index'));
    }
    public function destroy(Author $author)
    {
        if (!$author){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('authors.index'));
        }
        $path='default-user.png';
        if ($author->photo!=$path) {
            Storage::disk('public')->delete('authors/'.$author->photo);
        }
        $author->delete();
        toast('عمليه ناجحة','success')->position('top-start');
        return redirect(route('authors.index'));
    }

}
