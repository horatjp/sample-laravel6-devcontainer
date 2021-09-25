<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Manager extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $table = 'manager';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [];

    protected $guard_name = 'backend';



    public function createLoginHistory()
    {
        $managerLoginHistory = new ManagerLoginHistory();

        $managerLoginHistory->manager_id = $this->id;
        $managerLoginHistory->ip_address = request()->ip();
        $managerLoginHistory->user_agent = request()->header('User-Agent');
        $managerLoginHistory->created_at = now();

        $managerLoginHistory->save();
    }
}
