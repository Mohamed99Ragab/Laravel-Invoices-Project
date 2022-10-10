<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{

    function __construct()
    {
//        $this->middleware('permission:اضافة مستخدم', ['only' => ['index']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }



    public function index(Request $request)
    {
        $user_open = User::find(Auth::user()->id);
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data','user_open'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }


    public function store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        if($request->hasFile('photo')){
            $input['photo'] = $request->file('photo')->hashName();
        }
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        //upload photo
        if($request->hasFile('photo')){

            $photo_name = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->store('users/','public');


        }


        session()->flash('success_create');
        return redirect()->route('users.index');
    }


//    public function show($id)
//    {
//        $user = User::find($id);
//        return view('users.show',compact('user'));
//    }

    public function EditUser(Request $request){

        $id = $request->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }


//    public function edit($id)
//    {
//        $user = User::find($id);
//        $roles = Role::pluck('name','name')->all();
//        $userRole = $user->roles->pluck('name','name')->all();
//
//        return view('users.edit',compact('user','roles','userRole'));
//    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if($request->hasFile('photo')) {
            $input['photo'] = $request->file('photo')->hashName();
        }
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        //delete last photo of user from on server
        if($request->hasFile('photo')){
            Storage::disk('public')->delete('users/'.$user->photo);
        }


        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        // update in store photo updated on server
        if($request->hasFile('photo')){

            $request->file('photo')->store('users/','public');
        }


        session()->flash('success_update');
        return redirect()->route('users.index');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        Storage::disk('public')->delete('users/'.$user->photo);

        session()->flash('success_delete');
        return redirect()->route('users.index');
    }
}
