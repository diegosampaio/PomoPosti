@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                Categorias
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModal">+</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('layouts.alerts')

                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categorias as $cat)
                                    <tr>
                                        <td>{{ $cat->tituloCategoria }}</td>
                                        <td>
                                            @if($cat->statusCategoria == 1)
                                                <span class="badge badge-success">Ativo</span>
                                            @else
                                                <span class="badge badge-danger">Inativo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-default"><i class="glyphicon glyphicon-edit"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Não há categorias cadastradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('categorias.store') }}" method="post">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="tituloCategoria">Nome da Categoria</label>
                                <input type="text" name="tituloCategoria" id="tituloCategoria" placeholder="Nome da Categoria" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="statusCategoria">Status</label>
                            <select name="statusCategoria" class="custom-select">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
