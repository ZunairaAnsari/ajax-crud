<?php

namespace App\Http\Controllers;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //

    public function index(){
        
    }

    public function create(){
        return view('register');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'password' => 'required|min:4',
            'birthdate' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'errors' => $validator->messages()
            ]);
        } else {
            $student = new Student;
            $student->name = $request->input("name");
            $student->email = $request->input('email');
            $student->password = bcrypt($request->input('password'));
            $student->birthdate = $request->input('birthdate');
    
            try {
                $student->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Created Successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'An error occurred while saving the student: ' . $e->getMessage()
                ]);
            }
        }

    }

    public function show(){
        $students = Student::all();
        return response()->json([
           'status' => 200,
            'data' => $students
        ]);
    }

    public function edit($id){
        $student = Student::find($id);
        
        if($student){
            return response()->json([
                'status' => 200,
                'data' => $student
             ]);
        }
        else{
            return response()->json([
                'status' => 404,
               'message' => 'Student not found'
            ]);
        }
    }


    public function update(Request $request, $id) {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'birthdate' => 'required|date',
            'password' => 'nullable|string|min:6',
        ]);
    
        $student = Student::findOrFail($id);
        $student->name = $validatedData['name'];
        $student->email = $validatedData['email'];
        $student->birthdate = $validatedData['birthdate'];
        
        // Only update password if provided
        if (!empty($validatedData['password'])) {
            $student->password = bcrypt($validatedData['password']);
        }
    
        $student->save();
    
        return response()->json(['status' => 200, 'message' => 'Student updated successfully!']);
    }
    
   
}
