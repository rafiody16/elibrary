<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use Carbon\Carbon;

class DelayCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:calculate-delay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate overdue fines for all borrowed loans daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $loans = Loan::whereIn('status', ['borrowed', 'overdue'])->get();
        $finePerDay = 1000;
        $today = Carbon::now()->startOfDay();

        foreach ($loans as $loan) {
            $dueDate = Carbon::parse($loan->due_date)->startOfDay();

            if ($today->greaterThan($dueDate)) {
                $dayLate = abs($dueDate->diffInDays($today, false));
                $totalFine = $dayLate * $finePerDay;

                if ($loan->status === 'borrowed') {
                    $loan->status = 'overdue';
                }

                if ($loan->fine !== $totalFine) {
                    $loan->fine = $totalFine;
                }
                $loan->save();
            }
        }
        $this->info('Overdue fines calculated successfully for all loans.');
    }
}
