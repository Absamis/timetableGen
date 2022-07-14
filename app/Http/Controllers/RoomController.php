<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoomController extends Controller
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
        $room = DB::table('rooms')->limit(15)->get(['department', 'room_name', 'room_type', 'room_id']);
        return view('lecture-room', ["act" => array("text" => "Add", "url" => "/room"), "title" => "Lecture Room", "department" => $department, "room" => $room, "filter" => "all"]);
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
            "department" => ["required", "max:30"],
            "name" => ["required", "min:3", "max:20"],
            "rtype" => ["required"]
        ]);
        if (
            Room::where(['department' => $data["department"], "room_name" => $data["name"]])->first()
        ) {
            return back()->with(["error" => "Room details already exist"]);
        }
        $id = pageController::getUniqueID(Room::all(['room_id']), "room_id", 20);
        $storedata = Room::create([
            "department" => $data["department"],
            "room_name" => $data["name"],
            "room_type" => $data["rtype"],
            "room_id" => $id
        ]);
        if ($storedata) {
            return back()->with(["success" => "Room added successfully"]);
        } else {
            return back()->with(["error" => "Error occured, Try again later"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room, Request $request)
    {
        //
        $dept = $request->input("filter");
        if ($dept == "all")
            $room = DB::table('rooms')->limit(15)->get(['department', 'room_name', 'room_type', 'room_id']);
        else
            $room = DB::table('rooms')->where('department', $dept)->limit(15)->get(['department', 'room_name', 'room_type', 'room_id']);;
        $department = Department::all(['name']);
        return view('lecture-room', ["act" => array("text" => "Add", "url" => "/room"), "title" => "Lecture Room", "department" => $department, "room" => $room, "filter" => $dept]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        // if (Room::where('room_id', $id)->first()) {
        //     $info = Room::where('room_id', $id)->first();
        //     $department = Department::all(['name']);
        //     $room = DB::table('rooms')->limit(15)->get(['department', 'room_name', 'room_type', 'room_id']);
        //     return redirect()->route('ltroom')->with([
        //         "act" => array("text" => "Edit", "url" => "{$request->url()}"),
        //         "title" => "Lecture Room",
        //         "department" => $department,
        //         "room" => $room
        //     ])->withInput(["department" => $info["department"], "name" => $info["room_name"], "rtype" => $info["room_type"]]);;
        //     // return redirect()->route("lecture-room", ["act" => array("text" => "Edit", "url" => "/room")])->withInput(["department" => $info["department"], "name" => $info["room_name"], "rtype" => $info["room_type"]]);
        // } else {
        //     return back()->with(["error" => "No record found"]);
        // }
        return array("Better edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room, $id)
    {
        //
        if (Room::where('room_id', $id)->first()) {
            Room::where('room_id', $id)->delete();
            return back()->with(["success" => "Lecture Room Removed"]);
        } else {
            return back()->with(["error" => "No record found"]);
        }
    }
}
