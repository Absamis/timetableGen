<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class pageController extends Controller
{
    //
    public function index()
    {
        $saved = Table::all(["department", "session", "semester", "item_id"]);
        return view('home', ["title" => "Home", "savedtable" => $saved]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "session" => ["required", "regex: /^[0-9]{4}\/[0-9]{4}$/"],
            "semester" => ["required", "integer"]
        ]);

        $storedata = Session::updateOrCreate(
            ["session_date" => $data["session"]],
            ["session_term" => $data["semester"]]
        );
        if ($storedata) {
            return back()->with(["success" => "Saved"]);
        } else {
            return back()->with(["error" => "Error occured, try again later"]);
        }
    }
    static function getUniqueID($data = array(), $item = null, $len = 1)
    {
        $seen = true;
        while ($seen) {
            $seen = false;
            $id = Str::random($len);
            foreach ($data as $key => $value) {
                if ($value[$item] == $id) {
                    $seen = true;
                }
            }
            if (!$seen)
                return $id;
        }
    }
}
