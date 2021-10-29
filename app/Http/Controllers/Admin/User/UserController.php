<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
//        $this->middleware('can:edit-user,user')->only('edit');
//        $this->middleware('can:edit,user')->only('edit');

//        $this->middleware('can:show-users')->only('index');
        $this->middleware('can:create-user')->only(['create','store']);
        $this->middleware('can:edit-user')->only(['edit','update']);
        $this->middleware('can:delete-user')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query();

        if($search = \request('search')){
            $users->where('email','LIKE',"%$search%")
                ->orWhere('name','LIKE',"%$search%")
                ->orWhere('id',$search);
        }

        if(Gate::allows('show-staff-users')){
            if(\request('admin')){
                $users->where('is_superuser',1)->orWhere('is_staff',1);
            }else{
                $users->where('is_superuser',0)->orWhere('is_staff',0);
            }
        }

        $users = $users->latest()->paginate(20);
        return view('admin.users.all',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

         $user = User::create($data);
         if($request->has('verify')){
            $user->markEmailAsVerified();
         }
         return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
//        if(Gate::denies('edit-user',$user)){
//            abort(403);
//        }


//        $this->authorize('edit-user',$user);


//        if(auth()->user()->can('edit-user',$user)){
//            return view('admin.users.edit',compact('user'));
//        }
//        abort(403);

//        if(Gate::allows('edit',$user)){
//            return view('admin.users.edit',compact('user'));
//        }
//        abort(403);

//        $this->authorize('edit',$user);
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);
        if(! is_null($request->password)){
            $request->validate([
                'password' => ['required','string','min:8','confirmed']
            ]);
            $data['password'] = $request->password;
        }

        $user->update($data);
        if($request->has('verify')){
            $user->markEmailAsVerified();
        }
        alert()->success('کاربر مورد نظر شما با موفقیت ویرایش شد!');

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        alert()->success('کاربر مورد نظر شما از لیست کاربران حذف شد');
        return redirect(route('admin.users.index'));
    }
}
