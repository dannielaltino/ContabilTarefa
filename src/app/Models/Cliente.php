<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $guard = 'cliente';

    protected $fillable = [
        'userclientname',
        'userclientcnpj',
        'userclientemail',
        'tenant_id',
        'userclientinadimplente',
    ];

}
