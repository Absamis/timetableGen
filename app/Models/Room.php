<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $primarykey = 'room_id';
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = ["department", "room_name", "room_type", "room_id"];
}
