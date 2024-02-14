<?php

namespace App\Http\Controllers\Setting;

use App\Models\Setting;
use App\Models\NpsSetting;
use App\Models\NchlSetting;
use App\Models\NpaySetting;
use App\Models\AgentSetting;
use Illuminate\Http\Request;
use App\Models\PaypointSetting;
use App\Models\RebrandingSetting;
use App\Models\CybersourceSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\BankList;
use Illuminate\Database\QueryException;
use App\Wallet\Setting\Traits\UpdateSetting;

class SettingController extends Controller
{
    use UpdateSetting;

    public function generalSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.generalSetting')->with(compact('settings'));
    }

    public function rebrandingSetting(Request $request)
    {
        // Log::info('Rebranding request', [$request->all()]);
        $email = config('mail.from.address');
        $smtp_password = config('mail.password');
        $dbData = RebrandingSetting::firstOrFail();
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.rebrandingSetting')->with(compact('settings','dbData', 'email', 'smtp_password'));
    }
    public function npaySetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        $settings = $this->updatedSettingsCollection($request, NpaySetting::class);
        return view('admin.setting.npaySetting')->with(compact('settings'));
    }

    public function npsSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        $settings = $this->updatedSettingsCollection($request, NpsSetting::class);
        return view('admin.setting.npsSetting')->with(compact('settings'));
    }

    public function paypointCommissionSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.paypointCommissionSetting')->with(compact('settings'));
    }

    public function paypointSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request, PaypointSetting::class);
        return view('admin.setting.paypointSetting')->with(compact('settings'));
    }

    public function limitSetting(Request $request)
    {
        //dd($request->all());
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.limitSetting')->with(compact('settings'));
    }

    public function cashBackSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.cashbackSetting')->with(compact('settings'));
    }

    public function transactionFeeSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.transactionFee')->with(compact('settings'));
    }

    public function KYCSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.KYCSetting')->with(compact('settings'));
    }

    public function OTPSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.OTPSetting')->with(compact('settings'));
    }

    public function nchlLoadSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request, NchlSetting::class);
        return view('admin.setting.nchl.loadTransactionSetting')->with(compact('settings'));
    }

    public function nchlBankTransferSetting(Request $request)
    {

        if ($request->isMethod('POST')){
            // $settings = $this->updatedSettingsCollection($request, NchlSetting::class);

            $bank = BankList::where('id', $request->nchl_bank_transfer_bank_id)->first();

            if (strtolower($request->nchl_bank_transfer_for) == "user"){

                $request->merge([
                    'nchl_bank_transfer_debtor_bank_title' => $bank->bank_title,
                    'nchl_bank_transfer_debtor_agent' => $bank->debtor_agent,
                    'nchl_bank_transfer_debtor_branch' => $bank->debtor_branch,
                    'nchl_bank_transfer_debtor_name' => $bank->debtor_name,
                    'nchl_bank_transfer_debtor_account' => $bank->debtor_account,
                    'nchl_bank_transfer_debtor_id_type' => $bank->debtor_id_type,
                    'nchl_bank_transfer_debtor_id_value' => $bank->debtor_id_value,
                    'nchl_bank_transfer_debtor_address' => $bank->debtor_address,
                    'nchl_bank_transfer_debtor_phone' => $bank->debtor_phone,
                    'nchl_bank_transfer_debtor_mobile' => $bank->debtor_mobile,
                    'nchl_bank_transfer_debtor_email' => $bank->debtor_email,
                ]);

                $request->request->remove('nchl_bank_transfer_bank_id');
                $request->request->remove('nchl_bank_transfer_for');

                $this->updatedSettingsCollection($request, Setting::class);
                $this->updatedSettingsCollection($request, NchlSetting::class);

                return redirect()->back()->with('success', 'Debtor Bank for Users Updated Successfully');
            } else if (strtolower($request->nchl_bank_transfer_for) == "merchant"){

                $request->merge([
                    'nchl_bank_transfer_merchant_debtor_bank_title' => $bank->bank_title,
                    'nchl_bank_transfer_merchant_debtor_agent' => $bank->debtor_agent,
                    'nchl_bank_transfer_merchant_debtor_branch' => $bank->debtor_branch,
                    'nchl_bank_transfer_merchant_debtor_name' => $bank->debtor_name,
                    'nchl_bank_transfer_merchant_debtor_account' => $bank->debtor_account,
                    'nchl_bank_transfer_merchant_debtor_id_type' => $bank->debtor_id_type,
                    'nchl_bank_transfer_merchant_debtor_id_value' => $bank->debtor_id_value,
                    'nchl_bank_transfer_merchant_debtor_address' => $bank->debtor_address,
                    'nchl_bank_transfer_merchant_debtor_phone' => $bank->debtor_phone,
                    'nchl_bank_transfer_merchant_debtor_mobile' => $bank->debtor_mobile,
                    'nchl_bank_transfer_merchant_debtor_email' => $bank->debtor_email,
                ]);

                $request->request->remove('nchl_bank_transfer_bank_id');
                $request->request->remove('nchl_bank_transfer_for');

                $this->updatedSettingsCollection($request, Setting::class);
                $this->updatedSettingsCollection($request, NchlSetting::class);

                return redirect()->back()->with('success', 'Debtor Bank for Merchant Updated Successfully');
            } 

        }

        $settings = $this->updatedSettingsCollection($request, Setting::class);
        $settings = $this->updatedSettingsCollection($request, NchlSetting::class);
        $banks = BankList::all();
        return view('admin.setting.nchl.bankTransferSetting')->with(compact('settings', 'banks'));
    }

    public function addNewBank(Request $request)
    {

        if ($request->isMethod('POST')){

            $request->validate([
                'bank_title' => 'required|unique:bank_lists,bank_title',
                'debtor_agent' => 'required',
                'debtor_branch' => 'required',
                'debtor_name' => 'required',
                'debtor_account' => 'required',
                'debtor_id_type' => 'required',
                'debtor_id_value' => 'required',
                'debtor_address' => 'required',
                'debtor_phone' => 'required',
                'debtor_mobile' => 'required',
                'debtor_email' => 'required',
            ],[
                'bank_title.unique' => 'Bank Title Already Exists',
            ]);
            $bank = new BankList();
            $bank->bank_title = $request->bank_title;
            $bank->debtor_agent = $request->debtor_agent;
            $bank->debtor_branch = $request->debtor_branch;
            $bank->debtor_name = $request->debtor_name;
            $bank->debtor_account = $request->debtor_account;
            $bank->debtor_id_type = $request->debtor_id_type;
            $bank->debtor_id_value = $request->debtor_id_value;
            $bank->debtor_address = $request->debtor_address;
            $bank->debtor_phone = $request->debtor_phone;
            $bank->debtor_mobile = $request->debtor_mobile;
            $bank->debtor_email = $request->debtor_email;
            $bank->save();

            
            return redirect()->route('settings.nchl.bankTransfer')->with('success', 'Bank Added Successfully');

        }
        $settings = $this->updatedSettingsCollection($request, NchlSetting::class);
        return view('admin.setting.nchl.addBank')->with(compact('settings'));
    }

    public function nchlAggregatedPaymentSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        $settings = $this->updatedSettingsCollection($request, NchlSetting::class);
        return view('admin.setting.nchl.aggregatedPaymentSetting')->with(compact('settings'));
    }

    public function referral(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.referralSetting')->with(compact('settings'));
    }

    public function bonusSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.bonusSetting')->with(compact('settings'));
    }

    public function merchantSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.merchant.merchantSetting')->with(compact('settings'));
    }

    public function nicAsiaCyberSource(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        $settings = $this->updatedSettingsCollection($request, CybersourceSetting::class);
        return view('admin.setting.nicAsiaCyberSourceSetting')->with(compact('settings'));
    }

    public function notificationSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.notificationSetting')->with(compact('settings'));
    }


    public function redirectSetting(Request $request)
    {
        try {
            $settings = $this->updatedSettingsCollection($request, CybersourceSetting::class) ?? [];
        }catch (QueryException $e){
            Log::info($e);
        }
        try {
            $settings = $this->updatedSettingsCollection($request, NpaySetting::class) ?? [];
        }catch (QueryException $e){
            Log::info($e);
        }

        try {
            $settings = $this->updatedSettingsCollection($request, NpsSetting::class) ?? [];
        }catch (QueryException $e){
            Log::info($e);
        }

        try {
            $settings = $this->updatedSettingsCollection($request, NchlSetting::class) ?? [];
        }catch (QueryException $e){
            Log::info($e);
        }

        $settings = $this->updatedSettingsCollection($request);

        return view('admin.setting.redirectSetting')->with(compact('settings'));
    }

    public function agentBonusBalanceSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        $settings = $this->updatedSettingsCollection($request, AgentSetting::class);
        return view('admin.setting.agentSetting')->with(compact('settings'));
    }

    public function userActivityBonusSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        $settings = $this->updatedSettingsCollection($request, NpaySetting::class);
        return view('admin.setting.userActivityBonusSetting')->with(compact('settings'));
    }

    //Balance Limit for NTC and Khalti
    public function balanceLimitSetting(Request $request)
    {
        $settings = $this->updatedSettingsCollection($request);
        return view('admin.setting.vendorBalanceLimitSetting')->with(compact('settings'));
    }
    
}
