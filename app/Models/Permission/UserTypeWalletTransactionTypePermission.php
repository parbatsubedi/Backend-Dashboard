<?php

namespace App\Models\Permission;

use Illuminate\Foundation\Auth\User as Authenticatable;


class UserTypeWalletTransactionTypePermission extends Authenticatable
{
    protected $connection = "dpaisa";
    protected $table = 'user_type_wallet_transaction_type_permissions';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


}
