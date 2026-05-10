<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;


#[Table('usuario_contabilidade', key: 'accountinguserid')]
class Contabilidade extends Authenticatable
{
    use Notifiable;
    public $incrementing = false;

    public $timestamps = false;

    protected $guard = 'contabil';

    protected $table = 'usuario_contabilidade';

    protected $primaryKey = 'accountinguserid';

    protected $keyType = 'int';

    protected $fillable = [
        'accountinguserid',
        'accountinguserdesc',
        'cpf_usuario',
        'accountinguseremail',
        'tenant_id',
        'accountingusertoken',
        'accountingusertimestamp',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function execucaoServico()
    {
        return $this->hasMany(ExecucaoServico::class, 'usuario_cont_id');
    }

    public function guardName(): string
    {
        return 'contabil';
    }

    public function routeNotificationForMail(Notification $notification): string
    {
        // Return email address only...
        return $this->accountinguseremail;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->accountinguserid)) {
                $max = DB::table('usuario_contabilidade')->max('accountinguserid');
                $model->accountinguserid = ($max ?? 0) + 1;
            }
        });
    }

}
