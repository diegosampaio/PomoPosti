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
                                <th>Data</th>
                                <th>Concluidas</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($listaTarefas as $tar)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($tar['dataTarefa'])) }}</td>
                                    <td>{{ $tar['totalFinalizada'] }}</td>
                                    <td>{{ $tar['total'] }}</td>
                                    <td>
                                        <a href="{{ route('tarefas.lista', $tar['dataTarefa']) }}" class="btn btn-info btn-sm"><i class="fas fa-calendar-alt"></i> Ver Tarefas</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Não há tarefas cadastradas.</td>
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
