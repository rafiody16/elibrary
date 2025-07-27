<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    protected $table = 'loans';

    protected $primaryKey = 'id_loan';

    protected $fillable = [
        'id_user',
        'id_member',
        'id_book',
        'loan_date',
        'return_date',
        'status',
        'due_date',
        'fine',
    ];

    protected $dates = [
        'loan_date',
        'return_date',
        'due_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    protected $appends = ['totalFine'];

    public function getTotalFineAttribute()
    {
        return $this->fine;
    }

    public function calculatedDelay()
    {
        $dueDate = Carbon::parse($this->due_date)->startOfDay();
        $today = Carbon::now()->startOfDay();
        $finePerDay = 1000;

        if (in_array($this->status, ['borrowed', 'overdue']) && $today->greaterThan($dueDate)) {
            $daysLate = abs($dueDate->diffInDays($today, false));
            $totalFine = $daysLate * $finePerDay;

            if ($this->status === 'borrowed') {
                $this->status = 'overdue';
            }

            if ($this->fine !== $totalFine) {
                $this->fine = $totalFine;
            }

            $this->save();

            return $totalFine;
        } 
        return 0;
    }


}