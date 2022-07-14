<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $primaryKey = "item_id";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = ["department", "session", "semester", "data", "item_id"];
}
