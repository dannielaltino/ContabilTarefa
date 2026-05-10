<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


#[Table('execucao_servico', key: 'serviceexecutionid')]
class ExecucaoServico extends Model
{
    public $timestamps = false;

    protected $table = 'execucao_servico';

    protected $primaryKey = 'serviceexecutionid';

    protected $keyType = 'int';

    protected $fillable = [
        'serviceexecutionid',
        'datetime_creation',
        'usuario_cont_id',
        'usuario_cli_id',
        'servico_id',
    ];

    public function contabilidade()
    {
        return $this->belongsTo(Contabilidade::class, 'usuario_cont_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'usuario_cli_id');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }

    public function andamentoExecucao()
    {
        return $this->hasMany(AndamentoExecucao::class, 'execucao_servico_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->serviceexecutionid)) {
                $max = DB::table('execucao_servico')->max('serviceexecutionid');
                $model->serviceexecutionid = ($max ?? 0) + 1;
            }
        });
    }
}
