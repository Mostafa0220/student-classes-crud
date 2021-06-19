<?php

namespace App\Http\Controllers;

use App\Student;
use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Index function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/
     * shows the list page of students
     */
    public function index(Request $request)
    {
        
        
        if ($request->wantsJson()) {
            $students = Student::select('students.*', 'classes.class_name')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->get();
            // return JSON-formatted response
            return response ( $students, 200 );
        } else {
            $students = Student::select('students.*', 'classes.class_name')
            ->join('classes', 'students.class_id', '=', 'classes.id')
            ->paginate(10);
            // return HTML response
            return view('students/index', ['students' => $students]);
        }    
        
    }
/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$student = Student::find ( $id );
		
		if (! $student) {
			return response ( array (
					'message' => 'Record not found.' 
			), 404 );
		}
		
		return response ( $student, 200 );
	}
    /**
     * Add function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/add
     * shows the add page of students
     */
    public function addstudent()
    {
        $classArr = Classes::select('id', 'class_name')->get();
        return view('students/add', compact('classArr'));
    }

    /**
     * Edit function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/edit/{id}
     * shows the edit page of a student
     */
    public function editstudent($id)
    {
        if ($stud = Student::find($id)) {
            $classArr = Classes::select('id', 'class_name')->get();
            return view('students/edit', compact('classArr', 'stud'));
        } else {
            return redirect('/')->with('error', 'Student not found.');
        }
    }

    /**
     * Store function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/add
     * insert details of the student data
     */
    public function storestudent(Request $request)
    { 
        if ($request->wantsJson()) {
            $validator = Validator::make ( $request->all (), [ 
				'first_name' => 'bail|required|max:255',
                'last_name' => 'bail|required|max:255',
                'date_of_birth' => 'required|date_format:Y-m-d',
                'class_id' => 'required',
		    ] );
		
            if ($validator->fails ()) {
                return response ( [ 
                        'message' => 'Validation Failed',
                        'errors' => $validator->errors ()->all () 
                ] );
            }
            $first_name = ucwords($request->input('first_name'));
            $last_name = ucwords($request->input('last_name'));
            $date_of_birth = $request->input('date_of_birth');
            $class_id = $request->input('class_id');
            
            $data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'date_of_birth' => $date_of_birth,
                "class_id" => $class_id
            );
            $student = new Student ();
            $student->fill ( $data );
            $student->save ();
            
            return response ( $student, 201 );
        } else {
       
            if ($request->exists('submit')) {
            
                $validator = Validator::make($request->all(), [
                    'first_name' => 'bail|required|max:255',
                    'last_name' => 'bail|required|max:255',
                    'date_of_birth' => 'required|date_format:Y-m-d',
                    'address' => 'required',
                    'class_id' => 'required',
                    'e_mail' => 'bail|required|email|unique:students|max:255',
                    'student_image' => 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ]);

                //if validation fails redirect to add page with the user inputs
                if ($validator->fails()) {
                    return redirect('add')->withErrors($validator)->withInput();
                }

                $first_name = ucwords($request->input('first_name'));
                $last_name = ucwords($request->input('last_name'));
                $date_of_birth = $request->input('date_of_birth');
                $address = $request->input('address');
                $class_id = $request->input('class_id');
                $e_mail = $request->input('e_mail');
                $gender = $request->input('gender');

                // Check if a student image has been uploaded
                if ($request->hasFile('student_image')) {
                    // Get image file
                    $imgFile = $request->file('student_image');
                    $name = time();
                    // Make a image name [ student name + file extension]
                    $imageName = $name . '.' . $imgFile->getClientOriginalExtension();
                    // Upload image
                    $imgFile->move(public_path('images'), $imageName);
                }
                $data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'date_of_birth' => $date_of_birth,
                    "address" => $address,
                    "class_id" => $class_id, "e_mail" => $e_mail,
                    "gender" => $gender, "student_image" => $imageName
                );

                //insert data into student table
                Student::insert($data);
                return redirect('/')->with('success', 'Student created successfully.');
            }
            if ($request->exists('cancel')) {
                return redirect('/');
            }
        }
    }

    /**
     * Update function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/edit{id}
     * update details of a student
     */
    public function updatestudent(Request $request, $id)
    {
        if ($request->wantsJson()) {
            $validator = Validator::make ( $request->all (), [ 
				
				'first_name' => 'required|max:60',
				'last_name' => 'required|max:60',
				'class_id' => 'required|max:11',
                'date_of_birth' => 'required|date_format:Y-m-d',
            ] );
            
            if ($validator->fails ()) {
                return response ( [ 
                        'message' => 'Validation Failed',
                        'errors' => $validator->errors ()->all () 
                ] );
            }
            
        
            
            $student = Student::find ( $id );
            
            if (! $student) {
                return response ( array (
                        'message' => 'Record not found.' 
                ), 404 );
            }
            
            $student->fill ( $request->all () );
            
            $student->save ();
            
            return response ( $student, 200 );


        }else{
            if ($request->exists('submit')) {
                if ($stud = Student::find($id)) {
                    // Get old image of the student
                    $old_image = 'images/' . $stud->student_image;
    
                    $validator = Validator::make($request->all(), [
                        'first_name' => 'bail|required|max:255',
                        'last_name' => 'bail|required|max:255',
                        'date_of_birth' => 'required|date_format:Y-m-d',
                        'address' => 'required',
                        'class_id' => 'required',
                        'e_mail' => 'bail|required|email|unique:students,e_mail,' . $id . '|max:255',
                    ]);
    
                    //if validation fails redirect to edit page with the user inputs
                    if ($validator->fails()) {
                        return redirect('edit/' . $id)->withErrors($validator)->withInput();
                    }
    
                    $first_name = ucwords($request->input('first_name'));
                    $last_name = ucwords($request->input('last_name'));
                    $date_of_birth = $request->input('date_of_birth');
                    $address = $request->input('address');
                    $class_id = $request->input('class_id');
                    $e_mail = $request->input('e_mail');
                    $gender = $request->input('gender');
    
                    // Check if a student image has been uploaded
                    if ($request->hasFile('student_image')) {
    
                        $validator = Validator::make($request->all(), [
                            'student_image' => 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                        ]);
                        //if validation fails redirect to edit page with the user inputs
                        if ($validator->fails()) {
                            return redirect('edit/' . $id)->withErrors($validator)->withInput();
                        }
    
                        // Get image file
                        $imgFile = $request->file('student_image');
                        $name = time();
                        // Make a image name [ student name + file extension]
                        $imageName = $name . '.' . $imgFile->getClientOriginalExtension();
                        // Upload image
                        $imgFile->move(public_path('images'), $imageName);
                        // Delete the old image
                        unlink(public_path($old_image));
                    } else {
                        $imageName = $stud->student_image;
                    }
                    $data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'date_of_birth' => $date_of_birth,
                         "address" => $address,
                        "class_id" => $class_id, "e_mail" => $e_mail,
                        "gender" => $gender, "student_image" => $imageName
                    );
    
                    //update data into student table
                    Student::where('id', $id)->update($data);
                    return redirect('/')->with('success', 'Student updated successfully.');
                } else {
                    return redirect('/')->with('error', 'Student not found.');
                }
            }
            if ($request->exists('cancel')) {
                return redirect('/');
            }
        }
        
    }

    /**
     * Delete function for this controller.
     *
     * Maps to the following URL: http://localhost:8000/delete{id}
     * removes a student
     */
    public function deletestudent(Request $request, $id)
    {
        if ($request->wantsJson()) {
            $student = Student::find ( $id );
		
            if (! $student) {
                return response ( array (
                        'message' => 'Record not found.' 
                ), 404 );
            }
            
            $student->delete ();
            
            return response ( array (
                    'message' => 'Record was deleted.' 
            ), 200 );
        }else{
            if ($stud = Student::find($id)) {
                // Get image of the student
                $studimage = 'images/' . $stud->student_image;
                // Delete the old image
                unlink(public_path($studimage));
                Student::destroy($id);
                return redirect('/')->with('success', 'Student removed successfully');
            } else {
                return redirect('/')->with('error', 'Student not found.');
            }
        }
        
    }
}
