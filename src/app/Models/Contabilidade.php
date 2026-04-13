<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;


#[Table('usuario_contabilidade', key: 'accountinguserid')]
class Contabilidade extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $guard = 'contabil';

    protected $table = 'usuario_contabilidade';

    protected $primaryKey = 'accountinguserid';

    protected $fillable = [
        'accountinguserdesc',
        'cpf_usuario',
        'accountinguseremail',
        'tenant_id',
        'accountingusertoken',
        'accountingusertimestamp',
    ];

    public function guardName(): string
    {
        return 'contabil';
    }

    public function routeNotificationForMail(Notification $notification): string
    {
        // Return email address only...
        return $this->accountinguseremail;
    }

}
