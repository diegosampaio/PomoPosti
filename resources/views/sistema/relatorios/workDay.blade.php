@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('layouts.alerts')
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Filtre abaixo</div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">O que foi realizado</div>
                    <div class="card-body boxRelatorio">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
