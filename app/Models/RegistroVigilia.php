<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVigilia extends Model
{
    use HasFactory;

    protected $table = 'registros_vigilia';

    protected $fillable = [
        'user_id',
        'cpf_rg',
        'telefone',
        'idade',
        'nome_responsavel',
        'contato_responsavel',
        'parentesco',
        'termo_autorizacao_path',
        'doc_responsavel_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
