<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $department = Department::all(['name']);
        $rooms = Room::where('room_type', 'special')->get(['room_name']);
        $course = DB::table('courses')->limit(15)->get(["department", "level", "course_code", "course_id"]);
        return view('course', ["title" => "Course", "department" => $department, "room" => $rooms, "course" => $course, "filter" => "all"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            "department" => "required||max: 30",
            "level" => "required||max: 4",
            "title" => "required||string",
            "code" => "required||regex:/^[A-Z a-z]{3}\s{0,1}[0-9]{3}$/",
            "lecturer" => "required||max:30",
            "type" => "required||max: 10",
            "room" => "nullable||max:30",
        ]);
        if (
            Course::where(["department" => $data["department"], "level" => $data["level"], "course_code" => $data["code"], "course_type" => $data["type"]])->first()
        ) {
            return back()->with(["error" => "Course details already exist"]);
        }
        $id = pageController::getUniqueID(Course::all(['course_id']), "course_id", 20);
        $storedata = Course::create([
            "department" => $data["department"],
            "level" => $data["level"],
            "course_code" => $data["code"],
            "course_title" => $data["title"],
            "course_type" => $data["type"],
            "lecturer" => $data["lecturer"],
            "lecture_room" => $data["room"],
            "course_id" => $id
        ]);
        if ($storedata) {
            return back()->with(["success" => "Course added successfully"]);
        } else {
            return back()->with(["error" => "Error occured, Try again later"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $dept = $request->input("filter");
        $department = Department::all(['name']);
        if (Str::lower($dept) == 'all')
            $course = DB::table('courses')->limit(15)->get(["department", "level", "course_code", "course_id"]);
        else
            $course = DB::table('courses')->where('department', $dept)->limit(15)->get(["department", "level", "course_code", "course_id"]);
        $rooms = Room::where('room_type', 'special')->get(['room_name']);
        return view('course', ["title" => "Course", "department" => $department, "room" => $rooms, "course" => $course, "filter" => $dept]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, $id)
    {
        //
        if (Course::where('course_id', $id)->first()) {
            Course::where('course_id', $id)->delete();
            return back()->with(["success" => "Course Removed"]);
        } else {
            return back()->with(["error" => "No record found"]);
        }
    }
}
