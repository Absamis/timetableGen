<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $department = Department::all(['name', 'dept_id']);
        return view('department', ["title" => "Department", "department" => $department]);
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
            "department" => ["required", "max:30"]
        ]);
        if (Department::where('name', $data["department"])->first()) {
            return back()->with(["error" => "This department already exist"]);
        }
        $id = pageController::getUniqueID(Department::all(['dept_id']), "dept_id", 20);
        $storedata = Department::create([
            "name" => $data["department"],
            "dept_id" => $id
        ]);
        if ($storedata) {
            return back()->with(["success" => "Department added successfully"]);
        } else {
            return back()->with(["error" => "Error occured, Tr again later"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, $id)
    {
        //
        if (Department::where('dept_id', $id)->first()) {
            Department::where('dept_id', $id)->delete();
            return back()->with(["success" => "Department Removed"]);
        } else {
            return back()->with(["error" => "No record found"]);
        }
    }
}
