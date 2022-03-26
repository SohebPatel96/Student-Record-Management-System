<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Services\CountryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentRepository implements StudentInterface
{
    public function store($name, $phone_number, $email, $country_code)
    {
        $student = new Student;
        $student->name = trim($name);
        $student->phone_number = trim($phone_number);
        $student->email = trim($email);
        $student->country_code = trim($country_code);
        $student->country = (new CountryService())->get_country_name(trim($country_code));
        DB::transaction(function () use ($student) {
            $student->save();
        });
        return $student;
    }

    public function search($search_text, $page_no)
    {
        $search_text = trim($search_text);
        return Student::where('id', 'LIKE', '%' . $search_text . '%')
            ->orWhere('name', 'LIKE', '%' . $search_text . '%')
            ->orWhere('email', 'LIKE', '%' . $search_text . '%')
            ->orWhere('country_code', 'LIKE', '%' . $search_text . '%')
            ->orWhere('country', 'LIKE', '%' . $search_text . '%')
            ->paginate(5);
    }

    public function get_students()
    {
        return Student::paginate(5);
    }

    public function get_student_by_id($id)
    {
        return Student::findOrFail($id);
    }

    public function update($id, $name, $image)
    {
        $path = '';
        $student = Student::find($id);
        if (!is_null($image)) {
            $path =   $image->store(('/student_images'));
            if (!empty(trim($student->image))) {
                Storage::delete($student->image);
            }
            $student->image = $path;
        }
        $student->name = trim($name);
        $student->save();
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        if (!empty(trim($student->image))) {
            Storage::delete($student->image);
        }
        Student::where('id', $id)->delete();
    }
}
