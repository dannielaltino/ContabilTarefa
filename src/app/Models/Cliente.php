<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;


#[Table('usuario_cliente', key: 'userclientid')]
class Cliente extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $guard = 'cliente';

    protected $table = 'usuario_cliente';

    protected $primaryKey = 'userclientid';

    protected $fillable = [
        'userclientname',
        'userclientcnpj',
        'userclientemail',
        'tenant_id',
        'userclientinadimplente',
        'userclienttoken',
        'userclienttimestamp',
    ];

    public function guardName(): string
    {
        return 'cliente';
    }

    public function routeNotificationForMail(Notification $notification): array
    {
 
        // Return email address and name...
        return [$this->userclientemail => $this->userclientname];
    }

}
