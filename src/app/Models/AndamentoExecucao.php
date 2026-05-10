<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


#[Table('andamento_execucao', key: 'followup_id')]
class AndamentoExecucao extends Model
{
    public $timestamps = false;

    protected $table = 'andamento_execucao';

    protected $primaryKey = 'followup_id';

    protected $keyType = 'int';

    protected $fillable = [
        'followup_id',
        'execucao_servico_id',
        'followup_txt',
        'followup_datetime',
        'status_execution',
    ];

    public function execucaoServico()
    {
        return $this->belongsTo(ExecucaoServico::class, 'execucao_servico_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->followup_id)) {
                $max = DB::table('andamento_execucao')->max('followup_id');
                $model->followup_id = ($max ?? 0) + 1;
            }
        });
    }
}
