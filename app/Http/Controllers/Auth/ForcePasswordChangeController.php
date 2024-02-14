<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Models\User;
use App\Wallet\Dashboard\Repository\KYCDashboardRepository;
use App\Wallet\User\Repositories\UserKYCRepository;
use App\Wallet\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChangeController extends Controller
{
    public function forcePasswordChange(Request $request)
    {
        $user = User::where('id', $request->user_id)->firstOrFail();

        $user->update([
            'should_change_password' => 1,
            'should_change_password_message' => $request->reason
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->useLog("Force Password Change")
            ->withProperties(['user' => $request->user_id, 'reason' => $request->reason])
            ->log('User password change');

        return redirect()->back();
    }

    public function groupForcePasswordChange(Request $request, UserRepository $repository)
    {
        $groups = [
            'kyc_unfilled',
            'kyc_accepted',
            'kyc_rejected',
            'kyc_unverified'
        ];

        if ($request->isMethod('post')) {
            $selectedGroups = $request->groups;
            $reason = $request->reason;

            $updateArr = ['should_change_password' => 1, 'should_change_password_message' => $reason];

            if (in_array('kyc_unfilled', $selectedGroups)) {
                $repository->kycUnfilledQuery()->update($updateArr);
            }

            if (in_array('kyc_accepted', $selectedGroups)) {
                $repository->kycAcceptedQuery()->update($updateArr);
            }

            if (in_array('kyc_rejected', $selectedGroups)) {
                $repository->kycRejectedQuery()->update($updateArr);
            }

            if (in_array('kyc_unverified', $selectedGroups)) {
                $repository->kycUnverifiedQuery()->update($updateArr);
            }


            activity()
                ->causedBy(Auth::user())
                ->performedOn(new User())
                ->useLog("Force Password Change")
                ->withProperties(['groups' => $selectedGroups, 'reason' => $reason])
                ->log('Group password change for ' . implode(',', $selectedGroups) );


            return redirect()->back();

        }

        return view('admin.user.forcePasswordChange.groupForcePasswordChange')->with(compact('groups'));
    }


}
