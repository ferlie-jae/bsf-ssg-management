<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\Configuration\Section;
use App\Models\StudentSection;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentRegistrationMail;

class StudentRegistrationController extends Controller
{
    public function registrationComplete()
    {
        return view('auth.registration_success');
    }

    public function create()
    {
        $data = [
            'sections' => Section::get()
        ];
        return view('auth.register', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
			'school_id' => 'required|image|mimes:jpeg,png,jpg',
			'student_id' => ['required', 'unique:students,student_id', 'unique:users,username'],
			'section' => 'required',
			'first_name' => 'required',
			// 'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            // 'contact_number' => ['unique:students,contact_number'],
            // 'student_id' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

		$student = Student::create([
			'student_id' => $request->get('student_id'),
			// 'year_level' => $request->get('year_level'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
			'suffix' => $request->get('suffix'),
            'gender' => $request->get('gender'),
            'birth_date' => date('Y-m-d', strtotime($request->get('birth_date'))),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        StudentSection::create([
            'section_id' => $request->get('section'),
            'student_id' => $student->id
        ]);

        $password = base64_encode(time());
        $user = User::create([
            'username' => $request->get('student_id'),
            'email' => $request->get('email'),
            'password' => Hash::make($password),
            'temp_password' => $password
        ]);

        $user->assignRole(4);

        $file = $request->file('school_id');
        $mimeType = $file->getClientMimeType();
        $fileName = 'School ID validation'.'_'.date('m-d-Y H.i.s').'.'.$file->getClientOriginalExtension();

        /* $file_attachment = FileAttachment::create([
            'subject' => 'School ID validation',
            'mime_type' => $mimeType,
            'file_extension' => $file->getClientOriginalExtension(),
            'file_path' => $file->path(),
            'file_type' => explode("/", $mimeType)[0],
            'file_name' => $fileName,
            // 'data' => $blob,
        ]);

        $userFileAttachment = UserFileAttachment::create([
            'user_id' => $user->id,
            'file_attachment_id' => $file_attachment->id,
        ]); */
        
        $uploadPath = 'images/user/uploads/';
        Storage::disk('upload')->putFileAs($uploadPath, $file, $fileName);
        $user->update([
            'school_id_image' => $fileName
        ]);
        UserStudent::create([
            'user_id' => $user->id,
            'student_id' => $student->id
        ]);

        Mail::to($user->email)->send(new StudentRegistrationMail($user));

		// return redirect()->route('registration_complete')->with('alert-success', 'Saved');
    }
}
