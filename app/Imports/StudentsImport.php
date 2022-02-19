<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentSection;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\Configuration\Section;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StudentsImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        $sectionID = 0;
        foreach($rows as $row){
            if(!is_null($row['grade_section'])){
                // create section
                $getGrade = explode('-', trim($row['grade_section']))[0];
                if(
                    $getGrade == 7 ||
                    $getGrade == 8 ||
                    $getGrade == 9 ||
                    $getGrade == 10 ||
                    $getGrade == 11 ||
                    $getGrade == 12
                ){
                    $grade = 0;
                    $section_name = "";
                    foreach(explode('-', trim($row['grade_section'])) as $index => $grade_section)
                    {
                        if($index == 0){
                            $grade = $grade_section;
                        }else{
                            $section_name = $grade_section;
                        }
                    }
                    $section = Section::create([
                        'grade_level' => intval($grade),
                        'name' => $section_name,
                    ]);
                    $sectionID = $section->id;
                }else{
                    break;
                }
            }elseif(!is_null($row['student_id'])){
                // insert students
                $student = Student::create([
                    'student_id' => trim($row['student_id']),
                    'first_name' => trim($row['first_name']),
                    'middle_name' => trim($row['middle_name']),
                    'last_name' => trim($row['last_name']),
                    'suffix' => trim($row['suffix']),
                    'gender' => strtolower(trim($row['gender'])),
                ]);
    
                StudentSection::create([
                    'section_id' => $sectionID,
                    'student_id' => $student->id,
                ]);
    
                $user = User::create([
                    'is_verified' => 1,
                    'username' => $student->student_id,
                    'email' => strtolower($student->last_name).'.'.$student->id.'@dummy.com',
                    'password' => Hash::make($student->student_id.'-'.ucfirst($student->last_name)), // student_id-Lastname
                    'temp_password' => $student->student_id.'-'.ucfirst($student->last_name)
                ]);

                $user->assignRole(4);
                
                UserStudent::create([
                    'user_id' => $user->id,
                    'student_id' => $student->id,
                ]);
            }
        }
    }
}
