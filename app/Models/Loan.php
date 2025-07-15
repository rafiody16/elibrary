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

    protected $appends = ['calculated_fine'];

    public function scopeOverdue($query)
    {
        return $query->where('status', 'borrowed')
                     ->where('due_date', '<', now());
    }

    public function calculateFine($dailyRate = 1000)
    {
        if ($this->status === 'borrowed' && $this->due_date < now()) {
            $lateDays = now()->diffInDays($this->due_date);
            return $lateDays * $dailyRate;
        }

        if ($this->status === 'returned' && $this->return_date && $this->return_date > $this->due_date) {
            $lateDays = $this->return_date->diffInDays($this->due_date);
            return $lateDays * $dailyRate;
        }

        return 0;
    }

    public function getCalculatedFineAttribute()
    {
        return $this->calculateFine();
    }



}