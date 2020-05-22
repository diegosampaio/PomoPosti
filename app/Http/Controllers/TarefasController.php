<?php

namespace App\Http\Controllers;

use Carbon\Traits\Date;
use Illuminate\Http\Request;

use App\Models\Tarefa;
use App\Models\CiclosTrabalho;
use App\Models\TarefasComentario;


class TarefasController extends Controller
{
    private $tarefa, $ciclo, $comentario;

    public function __construct(Tarefa $tar,
                                CiclosTrabalho $cll,
                                TarefasComentario $com)
    {
        $this->middleware('auth');
        $this->tarefa = $tar;
        $this->ciclo = $cll;
        $this->comentario = $com;
    }

    /**
     * Lista todas as tarefas cadastradas
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tarefas = $this->tarefa->getListaDataGroup();

        $listaTarefas = [];
        if ($tarefas) {
            foreach ($tarefas as $tar) {
                $total = $this->tarefa->getTotalTarefaDiaStatus(auth()->user()->id, $tar->dataTarefa, null);
                $totalFinalizada = $this->tarefa->getTotalTarefaDiaStatus(auth()->user()->id, $tar->dataTarefa, 3);

                $lnTarefa = [
                    'dataTarefa' => $tar->dataTarefa,
                    'total' => $total,
                    'totalFinalizada' => $totalFinalizada
                ];

                $listaTarefas[] = $lnTarefa;
            }
        }

        return view('sistema.tarefas.index', compact('listaTarefas'));
    }

    /**
     * Cadastra Tarefa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $dadosForm = $request->all();
        $dadosForm['users_id'] = auth()->user()->id;
        $dadosForm['statusTarefa'] = 0;

        $response = $this->tarefa->create($dadosForm);
        if ($response) {
            return redirect()
                ->back()
                ->with('success', 'Tarefa cadastrada com sucesso!');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Erro ao cadastrar Tarefa!');
        }
    }

    /**
     * Mostra tela de trabalho
     *
     * @param int $idTarefa
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function work(int $idTarefa)
    {
        $tarefa = $this->tarefa->getTarefa(auth()->user()->id, $idTarefa);
        if (!$tarefa) {
            return redirect()
                ->back()
                ->with('error', 'Ops! Tarefa não econtrada!');
        }
        $comentarios = $this->comentario->where('tarefas_id', $tarefa->id)->orderBy('id', 'asc')->get();

        return view('sistema.tarefas.work', compact('tarefa', 'comentarios'));
    }


    public function upWork(Request $request)
    {
        $tarefa = $this->tarefa->getTarefa(auth()->user()->id, $request->trf);
        if (!$tarefa) {
            return "Ops! Tarefa não encontrada!";
        }

        // inicio da tarefa
        if ($request->action == 'play') {
            $this->ciclo->create(['tarefas_id' => $tarefa->id, 'dataInicio' => date('Y-m-d H:i:s')]);
            $tarefa->update(['statusTarefa' => 1]);
            $msgRetorno = '<span class="text-success">Tarefa iniciada.</span>';
        }
        // inicio da tarefa
        if ($request->action == 'stop') {
            $ciclo = $this->ciclo->where('tarefas_id', $tarefa->id)->whereNull('dataFim')->first();
            $ciclo->update(['dataFim' => date('Y-m-d H:i:s')]);
            $tarefa->update(['statusTarefa' => 2]);
            $msgRetorno = '<span class="text-success">Tarefa Encerrada.</span>';
        }

        return $msgRetorno;
    }

    public function cicloWork(Request $request)
    {
        $tarefa = $this->tarefa->getTarefa(auth()->user()->id, $request->trf);
        if (!$tarefa) {
            return "<tr><td colspan=\"4\">Ops! Tarefa não encontrada!</td></tr>";
        }

        $ciclo = $this->ciclo->where('tarefas_id', $tarefa->id)->orderBy('id', 'desc')->get();

        if (!$ciclo){
            $tblDados = "<tr><td colspan=\"4\">Não há dados registrados!</td></tr>";
        } else {
            $i = 1;
            $totalCiclo = $ciclo->count();
            foreach ($ciclo as $cl) {
                $total = '<small>Trabalhando...</small>';

                if ($cl->dataFim) {
                    $dataInicio = new \DateTime($cl->dataInicio);
                    $dataFim = new \DateTime($cl->dataFim);
                    $time = $dataInicio->diff($dataFim);
                    $horas = str_pad($time->h, 2,"0", STR_PAD_LEFT);
                    $minutos = str_pad($time->i, 2,"0", STR_PAD_LEFT);
                    $segundos = str_pad($time->s, 2,"0", STR_PAD_LEFT);
                    $total = "{$horas}:{$minutos}:{$segundos}";
                }

                $dataFim = ($cl->dataFim) ? date('d/m/Y H:i:s', strtotime($cl->dataFim)) : '<small>Trabalhando...</small>';

                echo "<tr>";
                echo "<td>#{$totalCiclo}</td>";
                echo "<td>".date('d/m/Y H:i:s', strtotime($cl->dataInicio))."</td>";
                echo "<td>".$dataFim."</td>";
                echo "<td>{$total}</td>";
                echo "</tr>";
                $totalCiclo--;
                $i++;
            }
        }
    }

    /**
     * Finaliza a tarefa
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function finish(Request $request)
    {
        $tarefa = $this->tarefa->getTarefa(auth()->user()->id, $request->trf);
        if (!$tarefa) {
            return "<tr><td colspan=\"4\">Ops! Tarefa não encontrada!</td></tr>";
        }

        if ($request->comentario){
            $dadosCom = [
                'tarefas_id' => $tarefa->id,
                'comentarios' => $request->comentario
            ];
            $respCom = $this->comentario->create($dadosCom);
        }

        $response = $tarefa->update(['dataFinalizacao' => date('Y-m-d H:i:s'), 'statusTarefa' => 3]);
        if($response) {
            return redirect()
                ->route('home')
                ->with('success', 'Tarefa concluida com sucesso!');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Ops! Erro ao concluir tarefa!');
        }

    }

    public function listData($data)
    {
        $lista = $this->tarefa->where('users_id', auth()->user()->id)->where('dataTarefa', $data)->get();

        return view('sistema.tarefas.lista', compact('lista'));
    }

    /**
     * Cadastra Comentario em uma tarefa.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComments(Request $request)
    {
        $tarefa = $this->tarefa->getTarefa(auth()->user()->id, $request->trf);
        if (!$tarefa) {
            return redirect()
                ->back()
                ->with('error', 'Ops! Tarefa não encontrada!');
        }

        $dadosCom = [
            'tarefas_id' => $tarefa->id,
            'comentarios' => $request->comentario
        ];
        $respCom = $this->comentario->create($dadosCom);

        if ($respCom) {
            return redirect()
                ->back()
                ->with('success', 'Comentario registrado com sucesso!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Ops! O comentário não pode ser registrado!');
        }
    }


    public function lixeira(Request $request)
    {
        $tarefa = $this->tarefa->getTarefa(auth()->user()->id, $request->trf);
        if (!$tarefa) {
            return redirect()
                ->back()
                ->with('error', 'Ops! Tarefa não encontrada!');
        }
        $response = $tarefa->update(['statusTarefa' => 4]);

        if ($response) {
            return redirect()
                ->route('tarefas')
                ->with('success', 'Sua tarefa foi enviada para lixeira com sucesso!');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Ops! Erro ao enviar Tarefa para lixeira!');
        }
    }

}
