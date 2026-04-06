<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contabilidade extends Authenticatable
{
    use Notifiable;

    protected $guard = 'contabil';

    protected $fillable = [
        'accountinguserdesc',
        'cpf_usuario',
        'accountinguseremail',
        'tenant_id',
    ];

}
