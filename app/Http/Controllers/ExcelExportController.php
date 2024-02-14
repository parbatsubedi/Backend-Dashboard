<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dispute;
use App\Models\UserKYC;
use App\Models\Clearance;
use App\Jobs\ProcessExcel;
use App\Models\ReportFile;
use App\Models\SparrowSMS;
use App\Models\TicketSale;
use App\Models\FundRequest;
use App\Models\AdminUserKYC;
use App\Models\LoadTestFund;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\AddSystemFund;
use App\Models\AdminUpdateKyc;
use App\Models\LinkedAccounts;
use App\Models\SwipeVotingVote;
use App\Models\NchlBankTransfer;
use App\Models\TransactionEvent;
use App\Models\UserCheckPayment;
use App\Models\UserLoginHistory;
use App\Models\AdminAlteredAgent;
use App\Models\BfiExecutePayment;
use App\Models\NpsLoadTransaction;
use App\Models\SamsaraTransaction;
use App\Models\MerchantTransaction;
use App\Models\NchlLoadTransaction;
use App\Models\UserLoadTransaction;
use App\Http\Resources\UserResource;
use App\Models\ClearanceTransaction;
use App\Models\IPAYRemitTransaction;
use App\Models\UserRegisteredByUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AgentResource;
use App\Models\BfiToUserFundTransfer;
use App\Models\KhaltiUserTransaction;
use App\Models\NchlAggregatedPayment;
use App\Models\NepalRemitTransaction;
use App\Models\UserToBfiFundTransfer;
use App\Wallet\AuditTrail\AuditTrial;
use App\Http\Resources\KhaltiResource;
use App\Models\AventozVoteTransaction;
use App\Models\CellPayUserTransaction;
use App\Models\NicAsiaSendTransaction;
use App\Models\Remit2NepalTransaction;
use App\Models\SwipeVotingParticipant;
use App\Models\UserToUserFundTransfer;
use App\Http\Resources\DisputeResource;
use App\Models\NicAsiaRemitTransaction;
use App\Models\NonRealTimeBankTransfer;
use App\Models\UnifiedRemitTransaction;
use App\Wallet\Excel\ExportExcelHelper;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\IPAYLoadResource;
use App\Http\Resources\MerchantResource;
use App\Jobs\ProcessPreTransactionExcel;
use App\Http\Resources\ClearanceResource;
use App\Wallet\AuditTrail\Behaviors\BAll;
use App\Http\Resources\NepalRemitResource;
use App\Http\Resources\SparrowSMSResource;
use App\Http\Resources\AgentDetailResource;
use App\Http\Resources\FundRequestResource;
use App\Http\Resources\NicAsiaLoadResource;
use App\Http\Resources\NicAsiaSendResource;
use App\Http\Resources\SamsaraLoadResource;
use App\Models\Microservice\PreTransaction;
use App\Models\SamsaraMoneyGramTransaction;
use App\Http\Resources\FundTransferResource;
use App\Models\EsewaBankTransferTransaction;
use App\Wallet\Commission\Models\Commission;
use App\Http\Resources\AventozVotingResource;
use App\Http\Resources\MoneyGramLoadResource;
use App\Models\Merchant\MerchantFundDocument;
use App\Wallet\DPaisaAuditTrail\PPAuditTrail;
use App\Http\Resources\AddSystemFundsResource;
use App\Http\Resources\AdminUpdateKycResource;
use App\Http\Resources\LinkedAccountsResource;
use App\Http\Resources\PreTransactionResource;
use App\Wallet\DPaisaAuditTrail\AllAuditTrail;
use App\Wallet\Helpers\TransactionIdGenerator;
use App\Http\Resources\BfiToUserReportResource;
use App\Http\Resources\Remit2NepalLoadResource;
use App\Http\Resources\SwipeVotingVoteResource;
use App\Http\Resources\UserToBfiReportResource;
use App\Wallet\DPaisaAuditTrail\NPayAuditTrail;
use App\Http\Resources\DPaisaAudit\NPayResource;
use App\Http\Resources\NchlBankTransferResource;
use App\Http\Resources\TransactionEventResource;
use App\Http\Resources\UnifiedRemitLoadResource;
use App\Http\Resources\UserCheckPaymentResource;
use App\Models\ReferAndEarn\ReferralTransaction;
use App\Http\Resources\AdminAlteredAgentResource;
use App\Http\Resources\EsewaBankTransferResource;
use App\Http\Resources\TicketSalesReportResource;
use App\Http\Resources\UserAudit\UserKYCResource;
use App\Models\NICAsiaCyberSourceLoadTransaction;
use App\Http\Resources\CellPayTransactionResource;
use App\Http\Resources\LoadTestFundReportResource;
use App\Http\Resources\UserAudit\CashBackResource;
use App\Models\Architecture\WalletTransactionType;
use App\Http\Resources\NchlLoadTransactionResource;
use App\Http\Resources\ReferralTransactionResource;
use App\Http\Resources\UserLoadTransactionResource;
use App\Http\Resources\ClearanceTransactionResource;
use App\Http\Resources\DPaisaAudit\PayPointResource;
use App\Http\Resources\UserRegisteredByUserResource;
use App\Http\Resources\RegisterUsingReferralResource;
use App\Http\Resources\WalletTransactionTypeResource;
use App\Http\Resources\SwipeVotingParticipantResource;
use App\Http\Resources\UserAudit\AdminUserKYCResource;
use App\Http\Resources\UserAudit\UserActivityResource;
use App\Http\Resources\BfiExecutePaymentReportResource;
use App\Http\Resources\MerchantPrefundDocumentResource;
use App\Http\Resources\NonRealTimeBankTransferResource;
use App\Models\Architecture\AgentTypeHierarchyCashback;
use App\Wallet\Report\Traits\SubscriberReportGenerator;
use App\Http\Resources\NchlAggregatedTransactionResource;
use App\Http\Resources\AgentTypeHierarchyCashbackResource;
use App\Http\Resources\UserAudit\UserLoginHistoryResource;
use App\Wallet\DPaisaAuditTrail\NchlBankTransferAuditTrail;
use App\Wallet\Report\Repositories\NchlLoadReportRepository;
use App\Wallet\DPaisaAuditTrail\NchlLoadTransactionAuditTrail;
use App\Wallet\TransactionEvent\Repository\NPayReportRepository;
use App\Http\Resources\NICAsiaCyberSourceLoadTransactionResource;
use App\Wallet\TransactionEvent\Repository\PayPointReportRepository;
use App\Http\Resources\DPaisaAudit\NCHLBankTransferAuditTrailResource;
use App\Http\Resources\DPaisaAudit\NchlLoadTransactionAuditTrailResource;

class ExcelExportController extends Controller
{

    use SubscriberReportGenerator;

    public function completeTransactions(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('complete_transactions')
            ->setGeneratorModel(TransactionEvent::class)
            ->setRequest($request)
            ->setResource(TransactionEventResource::class);
        return $export->exportExcel();
    }

    public function completeJobTransactions(Request $request)
    {

        $identifier = TransactionIdGenerator::generateReferral('REPORT-', 6);
        $report_title = 'complete_transactions';
        $create_report = ReportFile::create([
            'identifier' => $identifier,
            'report_title' => $report_title,
            'filter_request' => json_encode($request->all()),
            'admin_id' => Auth::user()->id
        ]);
        $report_identifier  = $create_report->identifier;
        dispatch(new ProcessExcel($request->all(), $create_report));
        // return back()->withErrors(['report_identifier' => $report_identifier]);
        return back()->with('report_identifier', $identifier);
    }

    public function checkReportStatus($identifier)
    {
        $report = ReportFile::where('identifier', $identifier)->first();
        if (!$report) {
            return response()->json(['status' => 'not_found']);
        }
        if (empty($report->file)) {
            return response()->json(['status' => 'processing']);
        }
        $downloadLink = route('download-excel', ['identifier' => $identifier]);
        return response()->json(['status' => 'completed', 'download_link' => $downloadLink]);
    }


    public function downloadExcel($identifier)
    {
        $report = ReportFile::where('identifier', $identifier)->first();
        // dd($report);
        if ($report) {
            $storagePath = storage_path('app/' . $report->file);
            if (Storage::exists($report->file)) {
                $originalName = basename($storagePath);
                return response()->download($storagePath, $originalName);
            }
        }
        return back()->withErrors(['message' => 'File not found']);
    }

    public function yearlyReport(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('yearly_report')
            ->setGeneratorModel(TransactionEvent::class)
            ->setRequest($request)
            ->setResource(TransactionEventResource::class);

        return $export->exportExcel();
    }

    public function monthlyReport(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('monthly_report')
            ->setGeneratorModel(TransactionEvent::class)
            ->setRequest($request)
            ->setResource(TransactionEventResource::class);

        return $export->exportExcel();
    }
    //user Excels start
    public function users(Request $request)
    {
        $request->merge(['user_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('users')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(UserResource::class);

        return $export->exportExcel();
    }

    public function kycRejectedUsers(Request $request)
    {
        $request->merge(['kyc_status' => "unverified", 'user_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('kyc Rejected Users')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(UserResource::class);

        return $export->exportExcel();
    }

    public function kycAcceptedUsers(Request $request)
    {
        $request->merge(['kyc_status' => "verified", 'user_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('kyc Accepted Users')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(UserResource::class);

        return $export->exportExcel();
    }
    public function kycPendingUsers(Request $request)
    {
        $request->merge(['kyc_status' => "pending", 'user_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('kyc Pending Users')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(UserResource::class);

        return $export->exportExcel();
    }

    public function kycNotFilledUsers(Request $request)
    {
        $request->merge(['kyc_status' => "notfilled", 'user_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('kyc Not Filled Users')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(UserResource::class);

        return $export->exportExcel();
    }

    public function deactivatedUsers(Request $request)
    {
        $request->merge(['user_only' => true, 'user_status' => "deactivated"]);
        $export = new ExportExcelHelper();
        $export->setName('Deactivated Users')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(UserResource::class);

        return $export->exportExcel();
    }
    //user Excels ends

    // system funds excels start

    public function addedSystemFund(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('System Funds List')
            ->setGeneratorModel(AddSystemFund::class)
            ->setRequest($request)
            ->setResource(AddSystemFundsResource::class);

        return $export->exportExcel();
    }

    //    merchants Excel
    public function merchants(Request $request)
    {
        $request->merge(['merchant_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('Merchants')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(MerchantResource::class);

        return $export->exportExcel();
    }

    public function kycUnverifiedMerchants(Request $request)
    {
        $request->merge(['kyc_status' => "unverified", 'merchant_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('Kyc Unverified Merchants')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(MerchantResource::class);

        return $export->exportExcel();
    }

    public function kycAcceptedMerchants(Request $request)
    {
        $request->merge(['kyc_status' => "verified", 'merchant_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('Kyc Accepted Merchants')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(MerchantResource::class);

        return $export->exportExcel();
    }

    public function kycNotFilledMerchants(Request $request)
    {
        $request->merge(['kyc_status' => "notfilled", 'merchant_only' => true]);
        $export = new ExportExcelHelper();
        $export->setName('Kyc Not Filled Merchants')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(MerchantResource::class);

        return $export->exportExcel();
    }

    //merchant Excels ends

    //admin updated Kyc
    public function adminUpdatedKyc(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Admin Updated KYC')
            ->setGeneratorModel(AdminUpdateKyc::class)
            ->setRequest($request)
            ->setResource(AdminUpdateKycResource::class);

        return $export->exportExcel();
    }

    // wallet Transaction Types Excel

    public function walletTransactionTypes(Request $request, $vendorName)
    {
        $request->merge(['vendorName' => $vendorName]);
        $export = new ExportExcelHelper();
        $export->setName('Wallet Transaction type ' . $vendorName)
            ->setGeneratorModel(WalletTransactionType::class)
            ->setRequest($request)
            ->setResource(WalletTransactionTypeResource::class);

        return $export->exportExcel();
    }

    //agents

    public function agent(Request $request)
    {
        $request->merge(['user_type' => 'agent']);
        $export = new ExportExcelHelper();
        $export->setName('agents')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(AgentResource::class);
        return $export->exportExcel();
    }

    public function agentDetails(Request $request)
    {
        $request->merge(['user_type' => 'agent']);
        $export = new ExportExcelHelper();
        $export->setName('agent-details')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(AgentDetailResource::class);
        return $export->exportExcel();
    }

    public function adminAlteredAgents(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Admin Altered Agents')
            ->setGeneratorModel(AdminAlteredAgent::class)
            ->setRequest($request)
            ->setResource(AdminAlteredAgentResource::class);
        return $export->exportExcel();
    }

    //agent type hierarchy Cashback
    public function agentTypeHierarchyCashback(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Agent Type Hierarchy Cashback')
            ->setGeneratorModel(AgentTypeHierarchyCashback::class)
            ->setRequest($request)
            ->setResource(AgentTypeHierarchyCashbackResource::class);
        return $export->exportExcel();
    }

    //    loadTestFunds

    public function loadTestFund(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Load Test Fund')
            ->setGeneratorModel(LoadTestFund::class)
            ->setRequest($request)
            ->setResource(AgentTypeHierarchyCashbackResource::class);
        return $export->exportExcel();
    }

    public function fundTransfer(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('fund_transfer')
            ->setGeneratorModel(UserToUserFundTransfer::class)
            ->setRequest($request)
            ->setResource(FundTransferResource::class);

        return $export->exportExcel();
    }

    public function fundRequest(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('fund_request')
            ->setGeneratorModel(FundRequest::class)
            ->setRequest($request)
            ->setResource(FundRequestResource::class);

        return $export->exportExcel();
    }

    public function nPay(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('EBanking')
            ->setGeneratorModel(UserLoadTransaction::class)
            ->setRequest($request)
            ->setResource(UserLoadTransactionResource::class);

        return $export->exportExcel();
    }

    public function nps(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('EBankingNPS')
            ->setGeneratorModel(NpsLoadTransaction::class)
            ->setRequest($request)
            ->setResource(UserLoadTransactionResource::class);

        return $export->exportExcel();
    }

    public function payPoint(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('paypoint')
            ->setGeneratorModel(UserCheckPayment::class)
            ->setRequest($request)
            ->setResource(UserCheckPaymentResource::class);

        return $export->exportExcel();
    }

    public function nchlAggregated(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('nchlAggregated')
            ->setGeneratorModel(NchlAggregatedPayment::class)
            ->setRequest($request)
            ->setResource(NchlAggregatedTransactionResource::class);
        return $export->exportExcel();
    }

    public function cellPay(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('cellPay')
            ->setGeneratorModel(CellPayUserTransaction::class)
            ->setRequest($request)
            ->setResource(CellPayTransactionResource::class);
        return $export->exportExcel();
    }

    public function linkedAccount(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('linkedAccounts')
            ->setGeneratorModel(LinkedAccounts::class)
            ->setRequest($request)
            ->setResource(LinkedAccountsResource::class);
        return $export->exportExcel();
    }

    public function nchlBankTransfer(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('NCHL Bank Transfer')
            ->setGeneratorModel(NchlBankTransfer::class)
            ->setRequest($request)
            ->setResource(NchlBankTransferResource::class);
        return $export->exportExcel();
    }

    public function khalti(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Khalti')
            ->setGeneratorModel(KhaltiUserTransaction::class)
            ->setRequest($request)
            ->setResource(KhaltiResource::class);
        return $export->exportExcel();
    }

    public function userCompleteTransactions(Request $request)
    {
        $user = User::where('mobile_no', $request->user)->first()->name;

        $export = new ExportExcelHelper();
        $export->setName($user . '_' . 'complete_transactions')
            ->setGeneratorModel(TransactionEvent::class)
            ->setRequest($request)
            ->setResource(TransactionEventResource::class);

        return $export->exportExcel();
    }

    public function cyberSource(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('CyberSource Nic Asia')
            ->setGeneratorModel(NICAsiaCyberSourceLoadTransaction::class)
            ->setRequest($request)
            ->setResource(NICAsiaCyberSourceLoadTransactionResource::class);

        return $export->exportExcel();
    }

    public function userNPay(Request $request)
    {
        $user = User::where('mobile_no', $request->user)->first()->name;

        $export = new ExportExcelHelper();
        $export->setName($user . '_' . 'npay')
            ->setGeneratorModel(UserLoadTransaction::class)
            ->setRequest($request)
            ->setResource(UserLoadTransactionResource::class);

        return $export->exportExcel();
    }

    public function failedNPay(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('failed_EBanking')
            ->setGeneratorModel(UserLoadTransaction::class)
            ->setRequest($request)
            ->setResource(UserLoadTransactionResource::class);

        return $export->exportExcel();
    }

    public function failedPayPoint(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('failed_paypoint')
            ->setGeneratorModel(UserCheckPayment::class)
            ->setRequest($request)
            ->setResource(UserCheckPaymentResource::class);

        return $export->exportExcel();
    }

    public function nPayClearance(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('nPay_clearance')
            ->setGeneratorModel(Clearance::class)
            ->setRequest($request)
            ->setResource(ClearanceResource::class);

        return $export->exportExcel();
    }

    public function payPointClearance(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('payPoint_clearance')
            ->setGeneratorModel(Clearance::class)
            ->setRequest($request)
            ->setResource(ClearanceResource::class);

        return $export->exportExcel();
    }

    public function clearanceTransaction(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('clearance_transactions')
            ->setGeneratorModel(ClearanceTransaction::class)
            ->setRequest($request)
            ->setResource(ClearanceTransactionResource::class);

        return $export->exportExcel();
    }


    public function disputes(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('disputes')
            ->setGeneratorModel(Dispute::class)
            ->setRequest($request)
            ->setResource(DisputeResource::class);

        return $export->exportExcel();
    }

    public function sparrowSMS(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('sparrow_sms')
            ->setGeneratorModel(SparrowSMS::class)
            ->setRequest($request)
            ->setResource(SparrowSMSResource::class);

        return $export->exportExcel();
    }

    public function allMerchantEvents(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('All Merchant Events')
            ->setGeneratorModel(SparrowSMS::class)
            ->setRequest($request)
            ->setResource(SparrowSMSResource::class);

        return $export->exportExcel();
    }

    private function transformAuditData($collection, $userId)
    {
        return $collection->transform(function ($value, $key) use ($userId) {
            if ($value instanceof AdminUserKYC) {
                return new AdminUserKYCResource($value);
            } elseif ($value instanceof UserLoginHistory) {
                return new UserLoginHistoryResource($value);
            } elseif ($value instanceof UserToUserFundTransfer) {
                return (new \App\Http\Resources\UserAudit\FundTransferResource($value))->setUserId($userId);
            } elseif ($value instanceof FundRequest) {
                return (new \App\Http\Resources\UserAudit\FundRequestResource($value))->setUserId($userId);
            } elseif ($value instanceof Commission && $value->module == Commission::MODULE_CASHBACK) {
                return new CashBackResource($value);
            } elseif ($value instanceof UserCheckPayment) {
                return new \App\Http\Resources\UserAudit\UserCheckPaymentResource($value);
            } elseif ($value instanceof UserLoadTransaction) {
                return new \App\Http\Resources\UserAudit\UserLoadTransactionResource($value);
            } elseif ($value instanceof UserKYC) {
                return new UserKYCResource($value);
            } elseif ($value instanceof UserActivity) {
                return new UserActivityResource($value);
            }
        });
    }

    private function transformSuccessfulAuditData($collection, $userId)
    {
        return $collection->transform(function ($value, $key) use ($userId) {
            if ($value instanceof AdminUserKYC) {
                return new AdminUserKYCResource($value);
            } elseif ($value instanceof UserLoginHistory) {
                return new UserLoginHistoryResource($value);
            } elseif ($value instanceof UserToUserFundTransfer) {
                return (new \App\Http\Resources\UserAudit\FundTransferResource($value))->setUserId($userId);
            } elseif ($value instanceof FundRequest) {
                return (new \App\Http\Resources\UserAudit\FundRequestResource($value))->setUserId($userId);
            } elseif ($value instanceof Commission && $value->module == Commission::MODULE_CASHBACK) {
                return new CashBackResource($value);
            } elseif ($value instanceof UserCheckPayment && !empty($value->userTransaction)) {
                return new \App\Http\Resources\UserAudit\UserCheckPaymentResource($value);
            } elseif ($value instanceof UserLoadTransaction && $value->status == 'COMPLETED') {
                return new \App\Http\Resources\UserAudit\UserLoadTransactionResource($value);
            } elseif ($value instanceof UserKYC) {
                return new UserKYCResource($value);
            } elseif ($value instanceof UserActivity) {
                return new UserActivityResource($value);
            }
        });
    }

    public function userAllAuditTrail(Request $request, $userId)
    {
        $IBehaviour = new BAll();
        $auditTrial = new AuditTrial($IBehaviour);
        $user = User::where('id', $userId)->firstOrFail();
        $collection = $auditTrial->setRequest($request)->createTrial($user);

        $collection = $this->transformAuditData($collection, $userId);
        //$collection = $this->transformSuccessfulAuditData($collection, $userId);

        $export = new ExportExcelHelper();
        $export->setName($user->name . '_audit_trail')
            ->setMixGeneratorModels($collection->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function dpaisaAllAuditTrail(Request $request)
    {
        $auditTrail = new AllAuditTrail();
        $collection = $auditTrail->createTrail();

        $collection->transform(function ($value) {

            if ($value instanceof UserCheckPayment) {
                return new PayPointResource($value);
            } elseif ($value instanceof UserLoadTransaction) {
                return new NPayResource($value);
            }
        });

        $export = new ExportExcelHelper();
        $export->setName('DPaisa_all_audit_trail')
            ->setMixGeneratorModels($collection->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function nchlBankTransferAuditTrail(Request $request)
    {
        $nchlBankTransfer = new NchlBankTransferAuditTrail();
        $collection = $nchlBankTransfer->createTrail();

        $collection->transform(function ($value) {
            return new NCHLBankTransferAuditTrailResource($value);
        });

        $export = new ExportExcelHelper();
        $export->setName('NCHL Bank Transfer Audit Trail')
            ->setMixGeneratorModels($collection->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function nchlLoadTransactionAuditTrail(Request $request)
    {
        $nchlLoad = new NchlLoadTransactionAuditTrail();
        $collection = $nchlLoad->createTrail();

        $collection->transform(function ($value) {
            return new NchlLoadTransactionAuditTrailResource($value);
        });

        $export = new ExportExcelHelper();
        $export->setName('NCHL Load Transaction Audit Trail')
            ->setMixGeneratorModels($collection->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function dpaisaNPayAuditTrail(Request $request)
    {
        $auditTrail = new NPayAuditTrail();
        $collection = $auditTrail->createTrail();

        $collection->transform(function ($value) {
            return new NPayResource($value);
        });

        $export = new ExportExcelHelper();
        $export->setName('npay_audit_trail')
            ->setMixGeneratorModels($collection->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function dpaisaPPAuditTrail(Request $request)
    {
        $auditTrail = new PPAuditTrail();
        $collection = $auditTrail->createTrail();

        $collection->transform(function ($value) {
            return new PayPointResource($value);
        });

        $export = new ExportExcelHelper();
        $export->setName('paypoint_audit_trail')
            ->setMixGeneratorModels($collection->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    //Reports
    public function payPointReport(Request $request, PayPointReportRepository $repo)
    {
        $export = new ExportExcelHelper();
        $export->setName('Paypoint Report')
            ->setMixGeneratorModels(($repo->generateServiceReport())->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function nchlLoadReport(Request $request, NchlLoadReportRepository $repo)
    {
        $export = new ExportExcelHelper();
        $export->setName('NCHL-LOAD Report')
            ->setMixGeneratorModels(($repo->generateServiceReport())->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }


    public function nPayReport(Request $request, NPayReportRepository $repo)
    {
        $export = new ExportExcelHelper();
        $export->setName('NPAY Report')
            ->setMixGeneratorModels(($repo->generateServiceReport())->filter())
            ->setRequest($request);

        return $export->exportExcelCollection();
    }

    public function userToBFIReport(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('USER TO BFI REPORT')
            ->setGeneratorModel(UserToBfiFundTransfer::class)
            ->setRequest($request)
            ->setResource(UserToBfiReportResource::class);

        return $export->exportExcel();
    }

    public function bfiToUserReport(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('BFI TO USER REPORT')
            ->setGeneratorModel(BfiToUserFundTransfer::class)
            ->setRequest($request)
            ->setResource(BfiToUserReportResource::class);

        return $export->exportExcel();
    }

    public function executePaymentReport(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('BFI EXECUTE PAYMENT REPORT')
            ->setGeneratorModel(BfiExecutePayment::class)
            ->setRequest($request)
            ->setResource(BfiExecutePaymentReportResource::class);
        return $export->exportExcel();
    }

    public function ticketSalesReport(Request $request)
    {
        $request->merge(['transaction_type' => TicketSale::class]);
        $export = new ExportExcelHelper();
        $export->setName('Ticket Sales Report')
            ->setGeneratorModel(TransactionEvent::class)
            ->setRequest($request)
            ->setResource(TicketSalesReportResource::class);
        return $export->exportExcel();
    }

    public function loadTestFundReport(Request $request)
    {
        $request->merge(['transaction_type' => LoadTestFund::class, 'service' => 'LUCKY WINNER']);
        $export = new ExportExcelHelper();
        $export->setName('Load Test Fund Report')
            ->setGeneratorModel(TransactionEvent::class)
            ->setRequest($request)
            ->setResource(LoadTestFundReportResource::class);
        return $export->exportExcel();
    }

    public function userRegisteredByUserReport(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Users Registered By Agents')
            ->setGeneratorModel(UserRegisteredByUser::class)
            ->setRequest($request)
            ->setResource(UserRegisteredByUserResource::class);
        return $export->exportExcel();
    }

    //pre Transaction Excel
    public function preTransaction(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Pre Transactions')
            ->setGeneratorModel(PreTransaction::class)
            ->setRequest($request)
            ->setResource(PreTransactionResource::class);
        return $export->exportExcel();
    }

    // nchl load transaction
    public function nchlLoadTransaction(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Nchl Load Transactions')
            ->setGeneratorModel(NchlLoadTransaction::class)
            ->setRequest($request)
            ->setResource(NchlLoadTransactionResource::class);
        return $export->exportExcel();
    }

    // merchant Transactions
    public function merchantTransaction(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Merchant Transactions')
            ->setGeneratorModel(MerchantTransaction::class)
            ->setRequest($request)
            ->setResource(NchlLoadTransactionResource::class);
        return $export->exportExcel();
    }

    // non real time bank transfer
    public function nonRealTimeBankTransfer(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Non Real Time Bank Transfer')
            ->setGeneratorModel(NonRealTimeBankTransfer::class)
            ->setRequest($request)
            ->setResource(NonRealTimeBankTransferResource::class);
        return $export->exportExcel();
    }

    //registerUsingReferralUserReport

    public function registerUsingReferral(Request $request)
    {
        $request->merge(['registered_using_referral' => true]);
        $export = new ExportExcelHelper();
        $export->setName('Register Using Referral')
            ->setGeneratorModel(User::class)
            ->setRequest($request)
            ->setResource(RegisterUsingReferralResource::class);
        return $export->exportExcel();
    }

    //SwipeVotingParticipantReport
    public function swipeVotingParticipant(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Swipe Voting Participants')
            ->setGeneratorModel(SwipeVotingParticipant::class)
            ->setRequest($request)
            ->setResource(SwipeVotingParticipantResource::class);

        return $export->exportExcel();
    }

    //SwipeVotingVoterReport
    public function swipeVotingVoter(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Swipe Voting Voters')
            ->setGeneratorModel(SwipeVotingVote::class)
            ->setRequest($request)
            ->setResource(SwipeVotingVoteResource::class);

        return $export->exportExcel();
    }

    // ReferralTransaction
    public function referralTransaction(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Referral Transactions')
            ->setGeneratorModel(ReferralTransaction::class)
            ->setRequest($request)
            ->setResource(ReferralTransactionResource::class);

        return $export->exportExcel();
    }

    //Samsara Remittance Load
    public function listSamsara(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_Samsara_Load_transactions')
            ->setGeneratorModel(SamsaraTransaction::class)
            ->setRequest($request)
            ->setResource(SamsaraLoadResource::class);

        return $export->exportExcel();
    }

    //Samsara Remittance Load
    public function listMoneyGram(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_MoneyGram_Load_Transaction')
            ->setGeneratorModel(SamsaraMoneyGramTransaction::class)
            ->setRequest($request)
            ->setResource(MoneyGramLoadResource::class);

        return $export->exportExcel();
    }

    //Samsara Remittance Load
    public function listRemit2Nepal(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_Remit2Nepal_Load_Transaction')
            ->setGeneratorModel(Remit2NepalTransaction::class)
            ->setRequest($request)
            ->setResource(Remit2NepalLoadResource::class);

        return $export->exportExcel();
    }

    //Merchant Prefund Document
    public function merchantPrefund(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('Merchant Prefund Documnet')
            ->setGeneratorModel(MerchantFundDocument::class)
            ->setRequest($request)
            ->setResource(MerchantPrefundDocumentResource::class);

        if (
            $request->from == null && $request->to == null && $request->mobile_number == null &&
            $request->email == null && $request->deposited_date == null &&  $request->depositor_name == null
        ) {
            $merchantPrefundLists = MerchantFundDocument::with('user', 'admin')
                ->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        } else {
            $merchantPrefundLists = MerchantFundDocument::with('user', 'admin')
                ->filter($request)->orderBy('id', 'DESC')->get();
        }

        return $export->exportExcelForMerchantPrefund($merchantPrefundLists);
    }

    //Nic Asia Remittance Load
    public function listNicAsia(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_NicAsia_Load_transactions')
            ->setGeneratorModel(NicAsiaRemitTransaction::class)
            ->setRequest($request)
            ->setResource(NicAsiaLoadResource::class);

        return $export->exportExcel();
    }

    //Nic Asia Remittance Send
    public function listNicAsiaSend(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_NicAsia_Send_transactions')
            ->setGeneratorModel(NicAsiaSendTransaction::class)
            ->setRequest($request)
            ->setResource(NicAsiaSendResource::class);

        return $export->exportExcel();
    }

    //List IPAY Remit
    public function listIPAYRemit(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_IPAY_Load_transactions')
            ->setGeneratorModel(IPAYRemitTransaction::class)
            ->setRequest($request)
            ->setResource(IPAYLoadResource::class);

        return $export->exportExcel();
    }

    //list unified remit load
    public function listUnifiedRemitLoad(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_Unified_Remit_transactions')
            ->setGeneratorModel(UnifiedRemitTransaction::class)
            ->setRequest($request)
            ->setResource(UnifiedRemitLoadResource::class);

        return $export->exportExcel();
    }

    //pretransaction job
    public function preTransactionJobExcel(Request $request)
    {
        $identifier = TransactionIdGenerator::generateReferral('REPORT-', 6);
        $report_title = 'pre_transactions';
        $create_report = ReportFile::create([
            'identifier' => $identifier,
            'report_title' => $report_title,
            'filter_request' => json_encode($request->all()),
            'admin_id' => Auth::user()->id
        ]);
        $report_identifier  = $create_report->identifier;
        dispatch(new ProcessPreTransactionExcel($request->all(), $create_report));
        // return back()->withErrors(['report_identifier' => $report_identifier]);
        return back()->with('report_identifier', $identifier);
    }


    //list esewa bank transfer
    public function listEsewaBankTransfer(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_Esewa_Bank_Transfer')
            ->setGeneratorModel(EsewaBankTransferTransaction::class)
            ->setRequest($request)
            ->setResource(EsewaBankTransferResource::class);
        // dd($export);
        return $export->exportExcel();
    }

    //list Nepal Remit
    public function listNepalRemit(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_Nepal_Remit')
            ->setGeneratorModel(NepalRemitTransaction::class)
            ->setRequest($request)
            ->setResource(NepalRemitResource::class);
        return $export->exportExcel();
    }

    //Aventoz Voting
    public function listAventozVoting(Request $request)
    {
        $export = new ExportExcelHelper();
        $export->setName('List_Aventoz_Voting_transactions')
            ->setGeneratorModel(AventozVoteTransaction::class)
            ->setRequest($request)
            ->setResource(AventozVotingResource::class);

        return $export->exportExcel();
    }
}
