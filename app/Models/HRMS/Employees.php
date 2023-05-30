<?php

namespace App\Models\HRMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'mobile', 
        'email', 
        'gender', 
        'birth_date', 
        'address', 
        'pincode', 
        'aadhar', 
        'emergency', 
        'salary', 
        'pos_id', 
        'doj', 
        'in_time', 
        'out_time', 
        'photo',
    ];
}
