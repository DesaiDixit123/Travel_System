<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corporate extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'corporate';  // Custom guard for corporate
    protected $table = 'corporates';  // Table name for corporate

    // Define fillable fields
    protected $fillable = [
        'company_name',
        'contact_person',
        'designation',
        'contact_number',
        'email',
        'address',
        'department',
        'password',
        'role', // Add role
    ];

    // Hide password and remember token
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define relationship with employees
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_name', 'company_name'); // Assuming 'company_name' is the foreign key
    }

    // You can add accessor for full name if needed
    public function getFullNameAttribute()
    {
        return $this->contact_person . ' - ' . $this->company_name;
    }
}
