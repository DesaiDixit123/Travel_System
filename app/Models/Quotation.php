<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Quotation extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_mobile',
        'corporate_mobile',
        'corporate_email',
        'employee_email',
        'company_name',
        'employee_name',
        'department',
        'hotel_limit',
        'flight',
        'other_expenses',
        'quotation',
        'status',
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
