<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    //

    public function create(){
        return view('employee.index');
    }

    public function store(Request $request){
        dd($request->all());
    //    $validator = Validator::make($request->all(),[
    //     'name' => 'required|string|max:255',
    //     'phone' => 'required|string|max:20',
    //     'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    //    ]);

    //    if($validator->fails()){
    //        return response()->json(['errors' => $validator->messages()],400);
    //    }

    //    else{
    //     $imageName = time().'.'.$request->image->getClientOriginalExtension();
    //     $request->image->move(public_path('images'), $imageName);

    //     $employee = new Employee();
    //     $employee->name = $request->name;
    //     $employee->phone = $request->phone;
    //     $employee->image = $imageName;
    //     $employee->save();

    //     return response()->json(['success' => 'Employee added successfully'],200);
    //    }
    }
}
