<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

#[Table('tenant', key: 'tenantid')]
class Tenant extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'tenant';

    protected $primaryKey = 'tenantid';

    protected $keyType = 'int';

    protected $fillable = [
        'tenantid',
        'tenantdesc',
        'tenantcnpj'
    ];

    public function cliente()
    {
        return $this->hasMany(Cliente::class, 'tenant_id');
    }

    public function contabil()
    {
        return $this->hasMany(Contabilidade::class, 'tenant_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tenantid)) {
                $max = DB::table('tenant')->max('tenantid');
                $model->tenantid = ($max ?? 0) + 1;
            }
        });
    }
}
