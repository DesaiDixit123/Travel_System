<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Quotation extends Model
{
    protected $fillable = [
        'employee_id',


        'employee_name',

        'employee_mobile',
        'employee_email',

        'company_name',
        'corporate_email',
        'corporate_mobile',
        'invoice_date',
        'travel_from',
        'travel_to',
        'bill_no',
        'from_to',
        'amount',
        'include',
        'status',
        'email_screenshot',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
