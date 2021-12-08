<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\Configuration\Section;
use App\Models\StudentSection;

class StudentController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:students.index', ['only' => ['index']]);
		$this->middleware('permission:students.create', ['only' => ['create','store']]);
		$this->middleware('permission:students.show', ['only' => ['show']]);
		$this->middleware('permission:students.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:students.destroy', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::select('*');
        $gradeLevel = Section::select('*');
        if(Auth::user()->hasrole('System Administrator')){
			$students->withTrashed();
			$gradeLevel->withTrashed();
		}
        $data = [
            'students' => $students->get(),
            'gradeLevels' => $gradeLevel->get()->groupBy('grade_level'),
        ];
        
		return view('students.index', $data);
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
			'roles' => $roles->get(),
			'sections' => Section::get()
		]);

		return response()->json([
			'modal_content' => view('students.create', $data)->render()
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
			'student_id' => ['required', 'unique:students,student_id'],
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'contact_number' => ['unique:students,contact_number']
        ]);

		$student = Student::create([
			'student_id' => $request->get('student_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
			'gender' => $request->get('gender'),
			'birth_date' => date('Y-m-d', strtotime($request->get('birth_date'))),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        StudentSection::create([
            'section_id' => $request->get('section'),
            'student_id' => $student->id
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

            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $student->id
            ]);

            
        }
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        if($student->user){
            $data = ([
                'student_show' => $student,
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
                'student_show' => $student,
                'roles' => $roles->get(),
            ]);
        }

		return response()->json([
			'modal_content' => view('students.show', $data)->render()
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
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
            'student_edit' => $student,
			'roles' => $roles->get(),
			'sections' => Section::get()
        ]);
        
        return response()->json([
			'modal_content' => view('students.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
			'student_id' => ['required', 'unique:students,student_id,'.$student->id],
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'contact_number' => ['unique:students,contact_number,'.$student->id]
        ]);

		$student->update([
			'student_id' => $request->get('student_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
            'gender' => $request->get('gender'),
            'birth_date' => date('Y-m-d', strtotime($request->get('birth_date'))),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        $student->section->update([
            'section_id' => $request->get('section')
        ]);

        return back()->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
	{
		if (request()->get('permanent')) {
			$student->section->forceDelete();
			$student->forceDelete();
		}else{
			$student->section->delete();
			$student->delete();
		}
		return redirect()->route('students.index')->with('alert-danger','Deleted');
	}

	public function restore($student)
	{
		$student = Student::withTrashed()->find($student);
		$student->restore();
		$student->section->restore();
		return redirect()->route('students.index')->with('alert-success','Restored');
    }
}
