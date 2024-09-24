<?php

namespace App\Http\Controllers;
use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //

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

    public function show(Request $request) {
        $query = Student::query();
    
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('birthdate', 'LIKE', "%{$search}%");
        }
    
        // Sorting functionality
        $sortField = $request->input('sort_field', 'id');
        $sortDirection = $request->input('sort_direction', 'asc'); 
        $query->orderBy($sortField, $sortDirection);
    
        // Pagination
        $students = $query->paginate(5); // Change 5 to whatever number you want per page
    
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

    public function delete($id){
        $student = Student::findOrFail($id);
      
        if($student){
            $student->delete();
            return response()->json([
               'status' => 200,
               'message' => 'Student deleted successfully'
            ]);
        }
    }
    
   
}
