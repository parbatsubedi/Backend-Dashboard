<?php

namespace App\Http\Controllers;

use App\Models\TransactionEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraphReportController extends Controller
{
    public function monthlyTransactionGraph(Request $request)
    {

        $selectedDate = explode('-', $request->date_month);

        $now = Carbon::now();

        $month = $selectedDate ? $selectedDate[1] : $now->format('m');
        $year = $selectedDate ? $selectedDate[0] : $now->format('Y');

        //get current month transaction
        $transactions = TransactionEvent::with('transactionable')->filter($request)
            ->get();

        //group by date
        $groupedTransactions =  $transactions
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y-m-d');
            });

        //return num of transactions and sum of transaction amount in each grouped date
        $groupedTransactions->transform(function ($value, $key) {
            return [
                'count' => count($value),
                'amount' => round($value->sum('amount'),2)
            ];
        });

        //newUsers this month
        $newUsersCount = User::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();

        return [
            'month' => $month,
            'year' => $year,
            'graph' => $groupedTransactions,
            'transactionCount' => count($transactions),
            'transactionAmount' => round($transactions->sum('amount'), 2),
            'usersInvolved' => $transactions->unique('user_id')->count('user_id'),
            'newUsersCount' => $newUsersCount
        ];

    }

    public function yearlyTransactionGraph(Request $request)
    {
        $now = Carbon::now();
        $year = $request->date_year ? $request->date_year : $now->format('Y');


        //get current year transaction
        $transactions = TransactionEvent::with('transactionable')->filter($request)
            ->get();

        $groupedTransactions =  $transactions
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('F');
            });

        //return num of transactions and sum of transaction amount in each grouped date
        $groupedTransactions->transform(function ($value, $key) {
            return [
                'count' => count($value),
                'amount' => round($value->sum('amount'), 2)
            ];
        });

        //newUsers this year
        $newUsersCount = User::whereYear('created_at', $year)->count();

        return [
            'graph' => $groupedTransactions,
            'transactionCount' => count($transactions),
            'transactionAmount' => round($transactions->sum('amount'), 2),
            'usersInvolved' => $transactions->unique('user_id')->count('user_id'),
            'newUsersCount' => $newUsersCount ?? 0
        ];

    }

    public function monthlyVendorGraph(Request $request)
    {
        $selectedDate = explode('-', $request->date_month);

        $now = Carbon::now();
        $month = $selectedDate ? $selectedDate[1] : $now->format('m');
        $year = $selectedDate ? $selectedDate[0] : $now->format('Y');

        //get current month transaction
        $transactions = TransactionEvent::with('transactionable')->filter($request)
            ->get();

        $groupedTransactions =  $transactions
            ->groupBy('vendor');

        //return num of transactions and sum of transaction amount in each grouped date
        $groupedTransactions->transform(function ($value, $key) {
            return [
                'count' => count($value),
                'amount' => round($value->sum('amount'), 2)
            ];
        });

        return json_encode($groupedTransactions);
    }

    public function yearlyVendorGraph(Request $request)
    {
        $now = Carbon::now();
        $year = $now->format('Y');

        //get current year transaction
        $transactions = TransactionEvent::with('transactionable')->filter($request)
            ->get();

        $groupedTransactions =  $transactions
            ->groupBy('vendor');

        //return num of transactions and sum of transaction amount in each grouped date
        $groupedTransactions->transform(function ($value, $key) {
            return [
                'count' => count($value),
                'amount' => round($value->sum('amount'), 2)
            ];
        });

        return json_encode($groupedTransactions);

    }
}
