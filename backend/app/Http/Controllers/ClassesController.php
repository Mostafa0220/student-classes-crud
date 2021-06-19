<?php

namespace App\Http\Controllers;

use App\Student;
use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    /**
     * Index function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/classes
     * shows the list page of classes
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $classes = Classes::select('*')
            ->get();
            // return JSON-formatted response
            return response ( $classes, 200 );
        } else {
            $classes = Classes::select('*')
                ->paginate(10);
            return view('classes/index', ['classes' => $classes]);
        }
    }

    /**
     * Add function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/addclass
     * shows the add page of classes
     */
    public function addclass()
    {
        $statuses = ['opened','closed'];
        
        return view('classes/add', compact('statuses'));
    }

    /**
     * Edit function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/edit/{id}
     * shows the edit page of a classes
     */
    public function editclass($id)
    {
        if ($class = Classes::find($id)) {
            $statuses = ['opened','closed'];
            return view('classes/edit', compact('class','statuses'));
        } else {
            return redirect('/')->with('error', 'Class not found.');
        }
    }

    /**
     * Store function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/addclass
     * insert details of the class data
     */
    public function storeclass(Request $request)
    { 
       //exists hasFile
        if ($request->exists('submit')) {
           
            $validator = Validator::make($request->all(), [
                'code' => 'alpha_dash|required|max:255',
                'class_name' => 'bail|required|max:255',
                'maximum_students' => 'required|numeric|min:0|not_in:0',
                'status' => 'required',
            ]);

            //if validation fails redirect to add page with the user inputs
            if ($validator->fails()) {
                return redirect('addclass')->withErrors($validator)->withInput();
            }

            $class_name = ucwords($request->input('class_name'));
            $code = $request->input('code');
            $maximum_students = $request->input('maximum_students');
            $status = $request->input('status');
            $description = $request->input('description');

            
            $data = array(
                'class_name' => $class_name,
                'code' => $code,
                 "maximum_students" => $maximum_students,
                "status" => $status, 
                "description" => $description
            );

            //insert data into class table
            Classes::insert($data);
            return redirect('/')->with('success', 'Class created successfully.');
        }
        if ($request->exists('cancel')) {
            return redirect('/classes');
        }
    }

    /**
     * Update function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/edit{id}
     * update details of a class
     */
    public function updateclass(Request $request, $id)
    {
        if ($request->exists('submit')) {
            if ($class = Classes::find($id)) {
               

                $validator = Validator::make($request->all(), [
                    'code' => 'alpha_dash|required|max:255',
                    'class_name' => 'bail|required|max:255',
                    'maximum_students' => 'required|numeric|min:0|not_in:0',
                    'status' => 'required',
                ]);

                //if validation fails redirect to edit page with the user inputs
                if ($validator->fails()) {
                    return redirect('editclass/' . $id)->withErrors($validator)->withInput();
                }

                $class_name = ucwords($request->input('class_name'));
                $code = $request->input('code');
                $maximum_students = $request->input('maximum_students');
                $status = $request->input('status');
                $description = $request->input('description');

                
                $data = array(
                    'class_name' => $class_name,
                    'code' => $code,
                     "maximum_students" => $maximum_students,
                    "status" => $status, 
                    "description" => $description
                );

                //update data into classes table
                Classes::where('id', $id)->update($data);
                return redirect('/classes')->with('success', 'Class updated successfully.');
            } else {
                return redirect('/')->with('error', 'Class not found.');
            }
        }
        if ($request->exists('cancel')) {
            return redirect('/classes');
        }
    }

    /**
     * Delete function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/delete{id}
     * removes a Class
     */
    public function deleteclass($id)
    {
        if ($class = Classes::find($id)) {
            
            Classes::destroy($id);
            return redirect('/classes')->with('success', 'Class removed successfully');
        } else {
            return redirect('/classes')->with('error', 'Class not found.');
        }
    }
}
