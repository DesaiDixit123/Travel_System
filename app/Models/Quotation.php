<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Quotation extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_mobile',
        'company_name',
        'corporate_mobile',
        'corporate_email',
        'department',
        'hotel_limit',
        'flight',
        'other_expenses',
        'Quotation',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
