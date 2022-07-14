<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = "course_id";
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = ["department", "level", "course_title", "course_code", "lecturer",  "course_type", "course_id", "lecture_room"];
}
