<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\Configuration\RolePermission\UserRole;
use App\Models\UserFaculty;
use App\Models\UserStudent;
use Carbon\Carbon;
use Auth;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.index', ['only' => ['index']]);
        $this->middleware('permission:users.create', ['only' => ['create','store']]);
        $this->middleware('permission:users.show', ['only' => ['show']]);
        $this->middleware('permission:users.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$users->withTrashed();
		}else{
			$users->where('id', '!=', '1');
		}
		
		$data = [
			'users' => $users->get()
		];
		return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
		}elseif(Auth::user()->hasrole('Administrator')){
			$roles->where('id', '!=', 1)->get();
		}else{
			$roles->whereNotIn('id', [1,2]);
        }

		$data = [
			'roles' => $roles->get(),
		];

		if(request()->ajax()){
			return response()->json([
				'modal_content' => view('users.create', $data)->render()
			]);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'user_id' => ['required'],
			'role' => ['required'],
			'username' => ['required', 'string', 'max:255', 'unique:users,username'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
		$user = User::create([
			'username' => $request->get('username'),
			'email' => $request->get('email'),
			'password' => Hash::make($request->get('password')),
        ]);
        
        $user->assignRole($request->role);
        
        if($request->get('type') == 'student') {
            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $request->get('user_id')
            ]);
        }else{
            UserFaculty::create([
                'user_id' => $user->id,
                'faculty_id' => $request->get('user_id')
            ]);
        }
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(request()->ajax()) {
            $data = [
                'user' => $user
            ];
            return response()->json([
                'modal_content' => view('users.show', $data)->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
        if(request()->ajax()){
            $roles = Role::select('*');
		
            if(Auth::user()->hasrole('System Administrator')){
                $roles = $roles;
                $user->withTrashed();
                // $employees->withTrashed();
            }elseif(Auth::user()->hasrole('Administrator')){
                $roles->where('id', '!=', 1)->get();
            }else{
                $roles->whereNotIn('id', [1,2]);
            }
            $data = [
                'user' => $user,
                'roles' => $roles->get()
            ];
            return response()->json([
                'modal_content' => view('users.edit', $data)->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // $user = User::find($user);

		$request->validate([
			'role' => ['required'],
			'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
		]);
		if($request->filled('password')){
			$request->validate([
				'password' => ['string', 'min:8', 'confirmed']
			]);
			$data = ([
				'username' => $request->get('username'),
				'email' => $request->get('email'),
				'password' => Hash::make($request->get('password')),
			]);
		}else{
			$data = ([
				'name' => $request->get('username'),
				'email' => $request->get('email'),
			]);
		}
		$user->update($data);
		
		// $user->timestamps = false;
		UserRole::where('model_id', $user->id)->update([
			'role_id' => $request->get('role'),
		]);
		// $user->assignRole($request->role);
		// return redirect()->route('users.index')->with('alert-success', 'User successfully updated');
		return redirect()->route('users.index')->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
	{
		if (request()->get('permanent')) {
			$user->forceDelete();
		}else{
			$user->delete();
		}
		return back()->with('alert-danger','Deleted');
		// return redirect()->route('users.index')->with('alert-danger','User successfully deleted');
	}

	public function restore($user)
	{
		$user = User::withTrashed()->find($user);
		$user->restore();
		return back()->with('alert-success','Restored');
		// return redirect()->route('users.index')->with('alert-success','User successfully restored');
    }
    
    public function account(User $user)
    {
        $data = [
            'user' => $user
        ];
        return view('users.account', $data);
    }

    public function updateAccount(Request $request, User $user)
    {
        $this->updateProfileImage($request, $user);
        if(!is_null($request->get('old_password'))){
            if(Hash::check($request->get('old_password'), $user->password)){
                $request->validate([
                    'old_password' => 'required',
                    'new_password' => 'required|confirmed|min:8|different:old_password'
                ]);
                $user->update([
                    'password' => Hash::make($request->get('new_password'))
                ]);
                return redirect()->route('account.index', $user->id)->with('alert-success', 'Password Changed');
            }else{
                return redirect()->route('account.index', $user->id)->with('alert-warning', 'Old Password is incorrect');
            }
        }
        else{
            return redirect()->route('account.index', $user->id)->with('alert-success', 'Saved');
        }
    }

    public function updateProfileImage($request ,$user)
    {
        if($request->file('image')){
            $avatar= $request->file('image');
            $thumbnailImage = Image::make($avatar);

            $storagePath = 'images/user/uploads';
            $fileName = $user->id . '_' . date('m-d-Y H.i.s') . '.' . $avatar->getClientOriginalExtension();
            $myimage = $thumbnailImage->fit(500);
            // Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
            $myimage->save($storagePath . '/' .$fileName);
            $user->update([
                'image' => $fileName
            ]);
            /* $file = $request->file('image');
            $fileName = $request->get('name') . '_' . date('m-d-Y H.i.s') . '.' . $file->getClientOriginalExtension();
            Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
            $user->update([
                'image' => $fileName
            ]); */
        }
    }
}
