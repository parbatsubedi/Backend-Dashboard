<?php

namespace App\Http\Controllers;

use App\Models\TransactionEvent;
use App\Wallet\Dashboard\Interfaces\DashboardStatsRepositoryInterface;
use App\Wallet\Dashboard\Repository\KYCDashboardRepository;
use App\Wallet\Dashboard\Repository\NchlBankTransferDashboardRepository;
use App\Wallet\Dashboard\Repository\NchlLoadDashboardRepository;
use App\Wallet\Dashboard\Repository\NPayDashboardRepository;
use App\Wallet\Dashboard\Repository\PayPointDashboardRepository;
use Carbon\Carbon;

class DashboardController extends Controller
{

    private $year;

    private $month;

    private $yesterday;

    private $today;

    private $oldestDate;

    public function __construct()
    {
        $this->year = Carbon::now()->format('Y');
        $this->month = Carbon::now()->format('m');
        $this->yesterday = date('Y-m-d', Carbon::yesterday()->timestamp);
        $this->today = date('Y-m-d', Carbon::today()->timestamp);
        $this->oldestDate = TransactionEvent::oldest()->first()->created_at ?? "";
    }

    private function generateTransactionStats($repository)
    {
        //yesterday stats
        $repository->setFrom($this->yesterday)
            ->setTo($this->yesterday);

        $yesterday = ['yesterday' => $repository->stats()];

        //today stats
        $repository->setFrom($this->today)
            ->setTo($this->today);

        $today = ['today' => $repository->stats()];

        return array_merge($yesterday, $today);
    }

    private function generateKYCStats(KYCDashboardRepository $repository)
    {
        return [
            'kycFilledCount' => $repository->totalKYCFilledUsersCount(),
            'kycNotFilledCount' => $repository->totalKYCNotFilledUsersCount(),
            'acceptedKycCount' => $repository->totalAcceptedKYC(),
            'rejectedKycCount' => $repository->totalRejectedKYC(),
            'unverifiedKycCount' => $repository->totalUnverifiedKYC(),
        ];
    }

    public function npay(NPayDashboardRepository $repository)
    {
        $stats = $this->generateTransactionStats($repository);
        $graph = json_encode($repository->vendorTypeGraph());
        $clearances = $repository->clearances();
        $disputes = $repository->disputes();

        return view('admin.dashboard.stats.npay')->with(compact('stats', 'graph', 'clearances', 'disputes'));
    }

    public function paypoint(PayPointDashboardRepository $repository)
    {
        $stats = $this->generateTransactionStats($repository);
        $graph = json_encode($repository->vendorTypeGraph());
        $clearances = $repository->clearances();
        $disputes = $repository->disputes();

        return view('admin.dashboard.stats.paypoint')->with(compact('stats', 'graph', 'clearances', 'disputes'));
    }

    public function kyc(KYCDashboardRepository $repository)
    {
        $stats = $this->generateKYCStats($repository);
        $pieChart = json_encode($repository->pieChartKYC());
        $newUsersPerMonth = json_encode($repository->graphUsers());
        $kycs = $repository->latestKYCs();


        return view('admin.dashboard.stats.kyc')->with(compact('kycs','stats', 'pieChart', 'newUsersPerMonth'));
    }

    public function nchlBankTransfer(NchlBankTransferDashboardRepository $repository)
    {
        $stats = $this->generateTransactionStats($repository);
        $disputes = $repository->disputes();
        return view('admin.dashboard.stats.nchlBankTransfer')->with(compact('stats','disputes'));
    }

    public function nchlLoadTransaction(NchlLoadDashboardRepository $repository)
    {
        $stats = $this->generateTransactionStats($repository);
        $disputes = $repository->disputes();
        return view('admin.dashboard.stats.nchlLoadTransaction')->with(compact('stats','disputes'));
    }
}
