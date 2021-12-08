<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\User;
use App\Models\UserFaculty;
use App\Models\Configuration\Section;
use App\Models\FacultySection;

class FacultyController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:faculties.index', ['only' => ['index']]);
		$this->middleware('permission:faculties.create', ['only' => ['create','store']]);
		$this->middleware('permission:faculties.show', ['only' => ['show']]);
		$this->middleware('permission:faculties.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:faculties.destroy', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::select('*');
        if(Auth::user()->hasrole('System Administrator')){
			$faculties->withTrashed();
		}
        $data = [
            'faculties' => $faculties->get()
        ];
        
		return view('faculties.index', $data);
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
        $data = ([
			'roles' => $roles->get()
		]);
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'faculty' => $faculty,
			]);
		} */

		return response()->json([
			'modal_content' => view('faculties.create', $data)->render()
		]);
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
			'faculty_id' => ['required', 'unique:faculties,faculty_id'],
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'contact_number' => ['unique:faculties,contact_number']
        ]);

		$faculty = Faculty::create([
			'faculty_id' => $request->get('faculty_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
			'gender' => $request->get('gender'),
			'birth_date' => $request->get('birth_date'),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);
        
        if($request->get('add_user_account')){
            $request->validate([
                'role' => ['required'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user = User::create([
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);

            $user->assignRole($request->get('role'));

            UserFaculty::create([
                'user_id' => $user->id,
                'faculty_id' => $faculty->id
            ]);

            
        }
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        if($faculty->user){
            $data = ([
                'faculty_show' => $faculty,
            ]);
        }else{
            $roles = Role::select('*');
            if(Auth::user()->hasrole('System Administrator')){
                $roles = $roles;
            }elseif(Auth::user()->hasrole('Administrator')){
                $roles->where('id', '!=', 1)->get();
            }else{
                $roles->whereNotIn('id', [1,2]);
            }
            $data = ([
                'faculty_show' => $faculty,
                'roles' => $roles->get(),
            ]);
        }
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'faculty' => $faculty,
			]);
		} */

		return response()->json([
			'modal_content' => view('faculties.show', $data)->render()
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        $roles = Role::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
		}elseif(Auth::user()->hasrole('Administrator')){
			$roles->where('id', '!=', 1)->get();
		}else{
			$roles->whereNotIn('id', [1,2]);
        }
        $data = ([
            'faculty_edit' => $faculty,
			'roles' => $roles->get(),
			'sections' => Section::get()
        ]);
        
        return response()->json([
			'modal_content' => view('faculties.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
			'faculty_id' => ['required', 'unique:faculties,faculty_id,'.$faculty->id],
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'contact_number' => ['unique:faculties,contact_number,'.$faculty->id]
        ]);

		$faculty->update([
			'faculty_id' => $request->get('faculty_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
			'gender' => $request->get('gender'),
			'birth_date' => $request->get('birth_date'),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        return back()->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
	{
		if (request()->get('permanent')) {
			$faculty->forceDelete();
		}else{
			$faculty->delete();
		}
		return back()->with('alert-danger','Deleted');
		// return redirect()->route('users.index')->with('alert-danger','User successfully deleted');
	}

	public function restore($faculty)
	{
		$faculty = Faculty::withTrashed()->find($faculty);
		$faculty->restore();
		return back()->with('alert-success','Restored');
		// return redirect()->route('users.index')->with('alert-success','User successfully restored');
	}
}
