<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tarefa;
use App\Models\CiclosTrabalho;
use App\Models\TarefasComentario;

class HomeController extends Controller
{
    private $tarefa, $ciclo, $comentario;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Tarefa $tar,
                                CiclosTrabalho $cl,
                                TarefasComentario $cmt)
    {
        $this->middleware('auth');
        $this->tarefa = $tar;
        $this->ciclo = $cl;
        $this->comentario = $cmt;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $idUser = auth()->user()->id;
        $dataAtual = date('Y-m-d');
        $tarefasDia = $this->tarefa->getTarefas($idUser, $dataAtual);
        $listaCiclos = $this->ciclo->getWorkDay($idUser, $dataAtual);
        $ciclos = [];
        if ($listaCiclos) {
            foreach ($listaCiclos as $cl) {
                $total = 'Não calculado';
                if ($cl->dataFim) {
                    $dataInicio = new \DateTime($cl->dataInicio);
                    $dataFim = new \DateTime($cl->dataFim);
                    $time = $dataInicio->diff($dataFim);
                    $horas = str_pad($time->h, 2,"0", STR_PAD_LEFT);
                    $minutos = str_pad($time->i, 2,"0", STR_PAD_LEFT);
                    $segundos = str_pad($time->s, 2,"0", STR_PAD_LEFT);
                    $total = "{$horas}:{$minutos}:{$segundos}";

                }

                $lnCiclo = [
                    'idTarefa' => $cl->tarefas_id,
                    'tituloTarefa' => $cl->tituloTarefa,
                    'dataInicio' => $cl->dataInicio,
                    'dataFim' => $cl->dataFim,
                    'totalTrabalhado' => $total,
                    'statusTarefa' => $cl->statusTarefa
                ];

                $ciclos[] = $lnCiclo;
            }
        }

        return view('sistema.home.index', compact('tarefasDia', 'ciclos'));
    }


    public function index2()
    {
        return view('sistema.home.index2');
    }


}
