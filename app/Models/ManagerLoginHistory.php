<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerLoginHistory extends Model
{

    protected $table = 'manager_login_history';

    protected $fillable = [];

    protected $hidden = [];

    protected $casts = [];

    public $timestamps = false;
}
