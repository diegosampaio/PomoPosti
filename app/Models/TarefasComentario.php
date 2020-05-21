<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarefasComentario extends Model
{
    protected $fillable = ['tarefas_id', 'comentarios'];
}
