<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = ['users_id', 'categorias_id', 'tituloTarefa', 'observacoes', 'dataTarefa', 'prazo', 'dataFinalizacao', 'statusTarefa'];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categorias_id');
    }

    /**
     * Lista tarefas por agrupamento de datas
     * @return mixed
     */
    public function getListaDataGroup()
    {
        return $this->groupBy('dataTarefa')
            ->orderBy('dataTarefa', 'desc')
            ->select('dataTarefa')
            ->get();
    }

    /**
     * Lista tarefas por data para o usuario
     *
     * @param int $idUser
     * @param $data
     * @return mixed
     */
    public function getTarefaData(int $idUser, $data)
    {
        return $this->where('users_id', $idUser)
            ->where('dataTarefa', $data)
            ->where('statusTarefa', '<', 3)
            ->orderBy('id','asc')
            ->get();
    }

    /**
     * Retorna o total de tarefa do dia e status
     *
     * @param int $idUser
     * @param $data
     * @param int|null $status
     * @return mixed
     */
    public function getTotalTarefaDiaStatus(int $idUser, $data, int $status = null)
    {
        $lista = $this->where('users_id', $idUser)
            ->where('statusTarefa', '<=', 3)
            ->where('dataTarefa', $data);

        if ($status) {
            $lista->where('statusTarefa', $status);
        }

        return $lista->count();
    }

    /**
     * Lista tarefas do dia para o usuario
     *
     * @param int $idUser
     * @param $data
     * @return mixed
     */
    public function getTarefas(int $idUser, $data)
    {
        return $this->where('users_id', $idUser)
            ->where('dataTarefa', '<=', $data)
            ->where('statusTarefa', '<', 3)
            ->orderBy('id','asc')
            ->get();
    }

    /**
     * Retorna tarefa do usuário
     *
     * @param int $idUser
     * @param int $idTarefa
     * @return mixed
     */
    public function getTarefa(int $idUser, int $idTarefa)
    {
        return $this->where('users_id', $idUser)
            ->where('id', $idTarefa)
            ->first();
    }
}
