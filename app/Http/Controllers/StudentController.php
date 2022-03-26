<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchStudentRequest;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentResourceCollection;
use App\Repositories\Student\StudentInterface;
use Exception;

class StudentController extends Controller
{
    private $student_repo;

    public function __construct(StudentInterface $student_repo)
    {
        $this->student_repo = $student_repo;
    }

    public function index()
    {
        $students = $this->student_repo->get_students();
        return view('students', ['students' => $students]);
    }

    public function update_page($id)
    {
        $student = $this->student_repo->get_student_by_id($id);
        return view('update_student', ['student' => $student]);
    }

    public function update(UpdateStudentRequest $request)
    {
        $image = $request->hasFile('image') ? $request->image : null;
        $student = $this->student_repo->update($request->id, $request->name, $image);
        return response()->json(['student' => $student, 200]);
    }

    public function delete($id)
    {
        $this->student_repo->delete($id);
        return redirect('/students');
    }

    public function store(StudentStoreRequest $request)
    {
        try {
            $student =  $this->student_repo->store($request->name, $request->phone_number, $request->email, $request->country_code);
            return response()->json([
                'student' => new StudentResource($student)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => "An unknown error occured"
            ], 500);
        }
    }

    public function search(SearchStudentRequest $request)
    {
        try {
            $students = $this->student_repo->search(trim($request->text), 0);
            return response()->json([
                'student' => new StudentResourceCollection($students)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => "An unknown error occured"
            ], 500);
        }
    }
}
