<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    function list(){
        return Student::all();
    }

    function addStudent(Request $req){
        $student = new Student();
        $student->name = $req->name;
        $student->email = $req->email;
        $student->phone = $req->phone;
        $student->address = $req->address;
        $student->password = $req->password;
       if( $student->save()){
        return response()->json(['message' => 'Student Added Successfully'], 200);
       } else{
        return response()->json(['message' => 'Failed to Add Student'], 400);
       }


    }
}
