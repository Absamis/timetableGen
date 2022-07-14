<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Room;
use App\Models\Table;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public $genLectPos = array();
    public $lecturer = array();
    public $lectpos = array();
    public $timing = array();
    public $table = array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $dept = Department::all(['name']);
        return view('timetable', ["title" => "Timetable", "department" => $dept, "filter" => ""]);
    }

    /**
     * Compute the time table
     */

    public function computeTable(Request $request)
    {
        $department = $request->input('department');
        $sbjperday = 0;
        $rooms = Room::where(['department' => $department, ['room_type', '<>', 'special']])->get('room_name');
        $allrooms = array();
        foreach ($rooms as $key => $value) {
            array_push($allrooms, $value["room_name"]);
        }
        $this->timing = array();
        $levels = array("nd1", "nd2", "hnd1", "hnd2");
        $time = array(
            8 => '8:00AM', 9 => "9:00AM", 10 => "10:00AM", 11 => "11:00AM", 12 => "12:00PM", 13 => "01:00PM", 14 => "02:00PM"
        );

        foreach ($levels as $level1) {
            $dept = Course::where(['department' => $department, 'level' => $level1])->get();
            $deptcnt = count($dept) + 3;
            //GET THE TIME INTERVAL AND NO OF CLASSES
            if ($deptcnt <= 15)
                $this->timing[$level1] = array("interval" => 2, "no_class" => 3);
            else if ($deptcnt > 15 && $deptcnt <= 20)
                $this->timing[$level1] = array("interval" => 1, "no_class" => 4);
            else if ($deptcnt > 20 && $deptcnt <= 25)
                $this->timing[$level1] = array("interval" => 1, "no_class" => 5);
            else
                $this->timing[$level1] = array("interval" => 1, "no_class" => 6);

            //GET LECTURER FOR EACH LEVEL

            $this->lecturer[$level1] = Course::where(['department' => $department, 'level' => $level1])->get(['lecturer', 'course_code', 'lecture_room']);
            foreach ($this->lecturer[$level1] as $key => $value) {
                if ($value["lecture_room"] == null) {
                    if ($allrooms) {
                        $rpos = rand(0, count($allrooms) - 1);
                        $value["lecture_room"] = $allrooms[$rpos];
                    } else {
                        $value["lecture_room"] = "";
                    }
                }
            }
            $this->lectpos[$level1] = array();
            //GENERATE A RANDOM POSITION FOR THE LECTURERS ON THE TABLE
            for ($i = 0; $i < count($this->lecturer[$level1]); $i++) {;
                while (true) {
                    $pos = rand(0, (($this->timing[$level1]["no_class"] * 5) - 1));
                    if (!in_array($pos, $this->lectpos[$level1])) {
                        array_push($this->lectpos[$level1], $pos);
                        break;
                    }
                }
            }
        }
        //CHECK IF THERE IS ANY CLASHS AND AMEND IT
        $match = array('1520' => "ch1", '2015' => '-ch1', '1525' => "ch2", "2515" => "-ch2", "2025" => "ch3", "2520" => "-ch3");
        foreach ($levels as $level) {
            $this->table[$level] = array();
            $tm1 = ($this->timing[$level]["no_class"] * 5);
            for ($a = 0; $a < count($this->lectpos[$level]); $a++) {
                foreach ($levels as $level1) {
                    if ($level != $level1) {
                        $tm2 = ($this->timing[$level1]["no_class"] * 5);
                        $cmp = strval($tm1) . strval($tm2);
                        for ($i = 0; $i < count($this->lectpos[$level1]); $i++) {
                            // if ($match($cmp) == "ch1"){

                            // }
                            if (($this->lecturer[$level][$a]["lecturer"] == $this->lecturer[$level1][$i]["lecturer"]) && ($this->lectpos[$level][$a] == $this->lectpos[$level1][$i])) {
                                $this->changePostion($level, $level1, $a, $i);
                            }
                        }
                    }
                }
            }
        }
        // echo "<br />";
        // print_r(json_encode($this->lecturer));
        //DISTRIBUTE THE LECTURE TO A TIME
        foreach ($levels as $level) {
            echo "<br/>Timetable for $level<br/>";
            $cnt = 0;
            // foreach ($this->lectpos[$level] as $pos) {
            for ($i = 0; $i < ($this->timing[$level]["no_class"] * 5); $i++) {
                if (in_array($i, $this->lectpos[$level])) {
                    array_push($this->table[$level], $this->lecturer[$level][$cnt]);
                    $cnt++;
                } else {
                    array_push($this->table[$level], "-");
                }
                // }
            }
        }
        // echo "<br />";
        // print_r(json_encode($this->table));

        $data = ["table" => json_encode($this->table), "class_no" => json_encode($this->timing), "level" => json_encode($levels), "time" => json_encode($time)];
        // return;
        return back()->with(["tabledata" => json_encode($data), "department" => $department, "table" => json_encode($this->table), "class_no" => json_encode($this->timing), "level" => json_encode($levels), "time" => json_encode($time)]);
    }

    public function changePostion($arg1, $arg2, $posarg1, $posarg2)
    {
        while (true) {
            $scs1 = false;
            $scs2 = false;
            $pos = rand(0, ($this->timing[$arg1]["no_class"] * 5) - 1);
            $pos1 = rand(0, ($this->timing[$arg2]["no_class"] * 5) - 1);
            if (!in_array($pos, $this->lectpos[$arg1]))
                $scs1 = true;
            if (!in_array($pos1, $this->lectpos[$arg2]))
                $scs2 = true;
            if (($scs1 && $scs2) && ($pos1 != $pos)) {
                $this->lectpos[$arg1][$posarg1] = $pos;
                $this->lectpos[$arg2][$posarg2] = $pos1;
                break;
            }
        }
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
            "department" => "required||max:30",
            "data" => "required"
        ]);
        $id = pageController::getUniqueID(Table::all(["item_id"]), "item_id", 20);
        $storedata = Table::updateOrCreate(
            ["department" => $data["department"], "session" => session('session_date'), "semester" => session('session_term')],
            ["item_id" => $id, "data" => $data["data"]]
        );
        if ($storedata) {
            return back()->with(["success" => "Timtable saved successfully"]);
        } else {
            return back()->with(["error" => "Error occured, Try again later"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function show(TimeTable $timeTable, $id)
    {
        //
        $data = Table::where('item_id', $id)->first(['session', 'semester', 'data', 'department']);
        return view('show-table', ["title" => "Timetable", "data" => $data["data"], "session" => $data["session"], "semester" => $data["semester"], "department" => $data["department"]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeTable $timeTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeTable $timeTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeTable $timeTable)
    {
        //
    }
}
