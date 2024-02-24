<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_review extends Model
{
    use HasFactory;
    protected $fillable =[
        'content',
        'count_star',
        'user_id',
    ];
}
