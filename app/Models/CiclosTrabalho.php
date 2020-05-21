<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CiclosTrabalho extends Model
{
    protected $fillable = ['tarefas_id', 'dataInicio', 'dataFim'];

    public function getWorkDay(int $idUser, $data)
    {
        return $this->join('tarefas', 'tarefas.id', 'ciclos_trabalhos.tarefas_id')
            ->whereBetween('ciclos_trabalhos.dataInicio', [$data." 00:00:00", $data." 23:59:59"])
            ->orderBy('ciclos_trabalhos.created_at', 'asc')
            ->get();
    }
}
