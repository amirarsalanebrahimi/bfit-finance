<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $startDate = Jalalian::now()->getFirstDayOfMonth()->toCarbon()->toDateString();
        $endDate = Jalalian::now()->getEndDayOfMonth()->toCarbon()->toDateString();

//        $balance = $totalIncome - $totalExpense;

        return Inertia::render('Dashboard', [
            'income' => Inertia::defer(function () use ($startDate, $endDate) {
                sleep(1);
                $totalIncome = Transaction::income()
                    ->dateRange($startDate, $endDate)
                    ->sum('amount');

                return number_format((int)$totalIncome);
            }),
            'expense' => Inertia::defer(function () use ($startDate, $endDate) {
                sleep(1);
                $totalExpense = Transaction::expense()
                    ->dateRange($startDate, $endDate)
                    ->sum('amount');

                return number_format((int)$totalExpense);
            }),
            'transactions' => Inertia::defer(fn () => TransactionResource::collection(Transaction::latest()->take(20)->get()))
        ]);
    }
}
