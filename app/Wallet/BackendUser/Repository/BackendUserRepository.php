<?php


namespace App\Wallet\BackendUser\Repository;


use App\Models\Admin;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackendUserRepository
{
    use ValidatesRequests;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $this->request['password'] = Hash::make($this->request->password);
        $user = Admin::create($this->request->toArray());

        $user->assignRole($this->request->roles);
    }

    public function updateProfile($admin)
    {
        $data = Arr::except($this->request->all(), '_token');
        $admin->update($data);
    }

    public function changePassword()
    {
        $this->validate($this->request,[
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ]);

        $data = $this->request->all();
        $check_password = Admin::where(['email' => Auth::guard()->user()->email])->first();

        $current_password = $data['current_password'];
        if(Hash::check($current_password,$check_password->password))
        {
            $password = bcrypt($data['new_password']);
            Admin::where('email',Auth::guard()->user()->email)->update(['password'=>$password]);
            return true;
        }
        else {
            return false;
        }
    }

    public function updatePermission($allPermissions, $user)
    {
        $allPermissionsName = $allPermissions->map(function ($item, $key) {
            return $item->name;
        })->toArray();

        $user->revokePermissionTo($allPermissionsName);
        $user->givePermissionTo($this->request->permissions);

    }

    public function updateRole($allRoles, $user)
    {

        $allRoles->map(function ($item, $key) use ($user){
            $user->removeRole($item->name);
        })->toArray();

        $user->assignRole($this->request->roles);

    }
}
