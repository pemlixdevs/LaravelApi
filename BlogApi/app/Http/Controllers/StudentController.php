<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class StudentController extends Controller
{
    function list()
    {
        return Student::all();
    }

    public function addStudent(Request $req)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:6',
            'phone' => 'required|numeric',
            'address' => 'required',
        ];

        $validation = Validator::make($req->all(), $rules);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->messages()], 400);
        }

        $student = new Student();
        $student->name = $req->name;
        $student->email = $req->email;
        $student->phone = $req->phone;
        $student->address = $req->address;
        $student->password = Hash::make($req->password);  // Password is now hashed

        if ($student->save()) {
            return response()->json(['message' => 'Student Added Successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to Add Student'], 500);
        }
    }

    public function updateStudent(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits:10',
            'address' => 'required|string|max:255',
            'password' => 'required|min:6',
        ]);

        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student Not Found'], 404);
        }

        $student->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'Student Updated Successfully'], 200);
    }

    function deleteStudent($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student Not Found'], 404);
        }
        $student->delete();
        return response()->json(['message' => 'Student Deleted Successfully'], 200);
    }

    function searchStudent(Request $request, $search)
    {
        // $search = request()->input('search');
        $students = Student::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->orWhere('address', 'like', '%' . $search . '%')
            ->get();
        return response()->json($students, 200);

    }


}
