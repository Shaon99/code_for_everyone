<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Admin;


class courseController extends Controller
{

    public function allCourse(){
        $d=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        $data=Course::all();
        return view('admin.courses.course',$d,compact('data'));
    }


    public function store(Request $request)
    {
       
        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->status = $request->status;

        if ($request->hasFile('image')){
            $extension = $request->image->getClientOriginalExtension();
            $filename = rand(10000,99999).time().'.'.$extension;
            $request->image->move('uploads/course_images/',$filename);
            $course->image = $filename;
        }
        $course->save();
        $data = Course::latest()->first();
        return response()->json($data, 200);
    }


    public function delete(Course $id)
    {
        unlink('uploads/course_images/'.$id->image);
        $id->delete();
        return response()->json('Successfully Deleted!!!',200);
    }
    public function edit(Course $id)
    {
        return response()->json($id,200);
    }

    public function update(Request $request, Course $id)
    {

        $id->name = $request->name;
        $id->description = $request->description;
        $id->price = $request->price;
        $id->status = $request->status;

        if ($request->hasFile('image')){
            unlink('uploads/course-images/'.$id->image);
            $extension = $request->image->getClientOriginalExtension();
            $filename = rand(10000,99999).time().'.'.$extension;
            $request->image->move('uploads/executive-images/',$filename);
            $id->image = $filename;
        }       
     
        dd($id);
        // $id->save();
        // return response()->json($id,200);
    }


}
