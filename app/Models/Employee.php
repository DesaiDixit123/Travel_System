<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Allowed fields to be mass assigned
    protected $fillable = [
        'id',
        'name',
        'email',
        'mobile',
        'department',
        'limit',
        'company_name',
    ];
}
