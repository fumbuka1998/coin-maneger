<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'date'
    ];

}