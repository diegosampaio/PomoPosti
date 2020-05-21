@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                Tarefas
                            </div>
                            <div class="col-md-2 text-right">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('layouts.alerts')

                        <table class="table table-striped table-hover table-sm">
                            <thead>
                            <tr>
                                <th>Tarefa</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($lista as $tar)
                                <tr>
                                    <td>
                                        <a href="{{ route('tarefas.play', $tar->id) }}">{{ $tar->tituloTarefa }}</a>
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($tar->dataTarefa)) }}</td>
                                    <td>
                                        @switch($tar->statusTarefa)
                                            @case(0)
                                            <span class="badge badge-default">A Iniciar</span>
                                            @break
                                            @case(1)
                                            <span class="badge badge-info">Em Andamento</span>
                                            @break
                                            @case(2)
                                            <span class="badge badge-warning">Pendente</span>
                                            @break
                                            @case(3)
                                            <span class="badge badge-success">Finalizado</span>
                                            @break
                                        @endswitch

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Não há tarefas cadastradas.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
