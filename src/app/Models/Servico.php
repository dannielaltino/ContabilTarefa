<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


#[Table('servico', key: 'servico_id')]
class Servico extends Model
{
    public $timestamps = false;

    protected $table = 'servico';

    protected $primaryKey = 'servico_id';

    protected $keyType = 'int';

    protected $fillable = [
        'servico_id',
        'servico_desc'
    ];

    public function execucaoServico()
    {
        return $this->hasMany(ExecucaoServico::class, 'servico_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->servico_id)) {
                $max = DB::table('servico')->max('servico_id');
                $model->servico_id = ($max ?? 0) + 1;
            }
        });
    }
}
