<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Str;
use App\Models\AdminUserKYC;
use Illuminate\Http\Request;
use App\Traits\CollectionPaginate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Wallet\BackendUser\Repository\BackendUserRepository;

class BackendUsersController extends Controller
{
    use CollectionPaginate;

    private $repository;

    public function __construct(BackendUserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function view()
    {
        $users = Admin::with('roles')->where('status', 1)->paginate(10);
        return view('admin.backendUser.view')->with(compact('users'));
    }

    public function create(Request $request)
    {
        $allRoles = Role::get();

        if ($request->isMethod('post')) {
            $this->repository->create();
            return redirect()->route('backendUser.view')->with('success', 'Backend User Successfully Created');
        }

        return view('admin.backendUser.create')->with(compact('allRoles'));
    }

    public function permission($id, Request $request)
    {
        $user = Admin::where('id', $id)->firstOrFail();
        $permissions = $user->getAllPermissions();
        $allPermissions = Permission::get();

        if ($request->isMethod('post'))
        {
            $this->repository->updatePermission($allPermissions, $user);
            return redirect(route('backendUser.view'))->with('success', 'Permissions updated successfully');
        }

        return view('admin.backendUser.permissions')->with(compact('user', 'permissions', 'allPermissions'));
    }

    public function role($id, Request $request)
    {
        $user = Admin::with('roles')->where('id', $id)->firstOrFail();
        $allRoles = Role::get();

        if ($request->isMethod('post'))
        {
            $this->repository->updateRole($allRoles, $user);
            return redirect(route('backendUser.view'))->with('success', 'Roles updates successfully');
        }

        return view('admin.backendUser.roles')->with(compact('user', 'allRoles'));
    }

   public function kycList(Request $request)
    {
        $user = Admin::whereId(auth()->user()->id)->firstOrFail();
        $lists = $user->kycList($user, $request);
        return view('admin.backendUser.kycList')->with(compact('lists'));
    }


    public function resetPassword(Request $request)
    {
        // dd($request->all());
        /* Get Password from view page form */
        $generatedPassword = $request->input('generatedPassword');
        Admin::where('id', $request->user_id)->update(['password' => Hash::make($generatedPassword)]);
        return redirect(route('backendUser.view'))->with('success', 'Password Successfully Reset! New Password for User ID '. $request->user_id. ' is ' .$generatedPassword);
        // return redirect()->back();
    }

    public function profile(Request $request)
    {
        $admin = Admin::where('id', auth()->user()->id)->firstOrFail();

        if ($request->isMethod('post')) {
            $this->repository->updateProfile($admin);
            return redirect()->route('backendUser.profile');
        }

        return view('admin.backendUser.profile')->with(compact('admin'));
    }

    public function changePassword (Request $request)
    {
        $admin = Admin::where('id', auth()->user()->id)->firstOrFail();

        if ($request->isMethod('post')) {

            $changedPasswordSuccessful = $this->repository->changePassword();
            if (!$changedPasswordSuccessful) {
                return redirect()->route('backendUser.changePassword')->with('error', 'Current password was invalid');
            }
            return redirect()->route('backendUser.changePassword')->with('success','Password updated Successfully!');
        }

        return view('admin.backendUser.changePassword')->with(compact('admin'));
    }
    public function deactivateUser ($id, Request $request)
    {
        $user = Admin::where('id', $id)->firstOrFail();
        Admin::where('id', $request->user_id)->update(['status' => '0']);
        return redirect(route('backendUser.view'))->with('success', 'Deactivated Successfully! User '. $user->name. ' has been deactivated!');
    }
}
