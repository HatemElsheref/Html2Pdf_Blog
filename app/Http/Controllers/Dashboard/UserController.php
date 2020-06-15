<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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

        $users=User::whereRoleIs('writer')->where(function ($query) use($request){

            return $query->when($request->search,function ($q) use ($request){

                return $q->where('name','like','%'.$request->search.'%');
            });
        })->latest()->paginate(5);

        return view('dashboard.users.index',compact('users'));

    }
    public function create()
    {
        return view('dashboard.users.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email',
            'password' => 'required|string|max:191|confirmed',
            'photo' => 'image|mimes:jpg,png,jpeg',
            'permissions' =>'required|array|min:1',
        ],[
            'name.required'=>'الاسم مطلوب',
            'password.required'=>'كلمة المرور مطلوبه',
            'password.confirmed'=>'تاكيد كلمة المرور',
            'password.max'=>'كلمة المرور يجب ان تكوت نص واقل من 191 حرف',
            'password.string'=>'كلمة المرور يجب ان تكوت نص واقل من 191 حرف',
            'permissions.required'=>'الصلاحيات  مطلوبه',
            'permissions.min'=>'يجب اختيار صلاحية واحده على الاقل',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.required'=>'البريد الالكترونى مطلوب',
            'email.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.unique'=>'هذا البريد الالكترونى موجود بالفعل',
            'photo.image'=>'الصوره الشخصيه يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->except(['permissions']);
        if ($request->hasFile('photo')){
            $photo_path='public/users';
            $request->file('photo')->storeAs($photo_path,$request->file('photo')->hashName());
            $validated_data['photo']=$request->file('photo')->hashName();
        }else{
            $path='default-user.png';
            $validated_data['photo']=$path;
        }
        $validated_data['password']=bcrypt($request->password);
        $user=User::create($validated_data);
        $user->attachRole('writer');
        $user->syncPermissions($request->permissions);

        if ($user){
            toast('عمليه ناجحة','success')->position('top-start');
        }else{
            toast('فشلت العمليه','error')->position('top-start');
        }

        return redirect(route('users.index'));
    }
    public function edit(User $user)
    {
        if ($user){
            return view('dashboard.users.edit',compact('user'));
        } else{
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('users.index'));
        }

    }
    public function update(Request $request, User $user)
    {
        if (!$user){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('users.index'));
        }

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
//            'password' => 'string|max:191',
            'photo' => 'image|mimes:jpg,png,jpeg',
            'permissions' =>'required|array|min:1',
        ],[
            'name.required'=>'الاسم مطلوب',
            'password.max'=>'كلمة المرور يجب ان تكوت نص واقل من 191 حرف',
            'password.string'=>'كلمة المرور يجب ان تكوت نص واقل من 191 حرف',
            'permissions.required'=>'الصلاحيات  مطلوبه',
            'permissions.min'=>'يجب اختيار صلاحية واحده على الاقل',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.required'=>'البريد الالكترونى مطلوب',
            'email.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.unique'=>'هذا البريد الالكترونى موجود بالفعل',
            'photo.image'=>'الصوره الشخصيه يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->except('permissions');
        if ($request->hasFile('photo')) {
            $path ='default-user.png';
            $photo_path = 'public/users';
            if ($user->photo !=$path) {
                Storage::disk('public')->delete('users/' . $user->photo);
            }
            $request->file('photo')->storeAs($photo_path, $request->file('photo')->hashName());
            $validated_data['photo'] = $request->file('photo')->hashName();
        }else{
            $validated_data['photo']=$user->photo;
        }
        if ($request->has('password') and $request->password!= null){
            $validated_data['password']=bcrypt($request->password);
        }   else{
            $validated_data['password']=$user->password;
        }
        $user->update($validated_data);

        if ($request->get('permissions')!=null)
            $user->syncPermissions($request->get('permissions'));
        else
            $user->detachPermissions(null); // take dafault role permissions

        if ($user){
        toast('عمليه ناجحة','success')->position('top-start');
    }else{
        toast('فشلت العمليه','error')->position('top-start');
    }


        return redirect(route('users.index'));
    }
    public function destroy(User $user)
    {
        if (!$user){
            toast(' غير موجود','info')->position('top-start');
            return redirect(route('users.index'));
        }
        $path='default-user.png';
        if ($user->photo!=$path) {
            Storage::disk('public')->delete('users/'.$user->photo);
        }
        $user->detachRole(null);
        $user->detachPermissions(null); // take dafault role permissions
        $user->delete();
        toast('عمليه ناجحة','success')->position('top-start');
        return redirect(route('users.index'));
    }
    public function profile(){
        $user=auth()->user();
        return view('dashboard.users.profile',compact('user'));
    }
    public function updateprofile(Request $request){
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.auth()->user()->id,
            'password' => 'confirmed',
            'photo' => 'image|mimes:jpg,png,jpeg',
        ],[
            'name.required'=>'الاسم مطلوب',
            'password.max'=>'كلمة المرور يجب ان تكوت نص واقل من 191 حرف',
            'password.string'=>'كلمة المرور يجب ان تكوت نص واقل من 191 حرف',
            'password.confirmed'=>'تاكيد خاطئ لكلمة المرور',
            'name.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'name.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.required'=>'البريد الالكترونى مطلوب',
            'email.string'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.max'=>'الاسم يجب ان يكون نص واقل من 191 حرف',
            'email.unique'=>'هذا البريد الالكترونى موجود بالفعل',
            'photo.image'=>'الصوره الشخصيه يجب ان تكون من نوع صوره jpg jpeg png '
        ]);
        $validated_data=$request->all();
        if ($request->hasFile('photo')) {
            $path ='default-user.png';
            $photo_path = 'public/users';
            if (auth()->user()->photo != $path) {
                Storage::disk('public')->delete('users/' . auth()->user()->photo);
            }
            $request->file('photo')->storeAs($photo_path, $request->file('photo')->hashName());
            $validated_data['photo'] = $request->file('photo')->hashName();
        }else{
            $validated_data['photo']=auth()->user()->photo;
        }
        if ($request->has('password') and $request->password!= null){
            $validated_data['password']=bcrypt($request->password);
        }   else{
            $validated_data['password']=auth()->user()->password;
        }
        auth()->user()->update($validated_data);
        auth()->loginUsingId(auth()->user()->id);

            toast('عمليه ناجحة','success')->position('top-start');
            return redirect()->route('profile');


    }
}
