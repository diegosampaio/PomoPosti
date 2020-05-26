@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
{{--                    <div class="card-header">Isso é o que você tem para fazer hoje, há @{{ listaTarefa.length }} tarefas. @{{ hello }}</div>--}}
                    <div class="card-body">
                        <example-component></example-component>
{{--                        <a href="javascript:void()" @click.prevent.stop="getChecklist">carregar</a>--}}
{{--                        <table class="table table-striped table-hover table-sm">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>Tarefa</th>--}}
{{--                                <th>Data</th>--}}
{{--                                <th>Status</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                                <tr v-for="item in listaTarefa" :key="item.id">--}}
{{--                                    <td>@{{ item.id }}</td>--}}
{{--                                    <td>@{{ item.tituloTarefa }}</td>--}}
{{--                                    <td>@{{ item.dataTarefa }}</td>--}}
{{--                                    <td>--}}
{{--                                        @{{ item.statusTarefa }}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}

{{--                                <tr v-if="listaTarefa.length == 0">--}}
{{--                                    <td colspan="4">Não há tarefas cadastradas.</td>--}}
{{--                                </tr>--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
                    </div>
                </div>
            </div><!--.col-md-6-->
            <div class="col-md-6">

            </div><!--.col-md-6-->
        </div>
    </div>
@endsection

@section('js')
{{--<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>--}}
{{--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>--}}

{{--<script>--}}
{{--var app = new Vue({--}}
{{--    el: '#app',--}}
{{--    data: {--}}
{{--        hello: 'Hello',--}}
{{--        listaTarefa: [],--}}
{{--        ciclos: []--}}
{{--    },--}}
{{--    created() {--}}
{{--        this.getChecklist()--}}
{{--    },--}}
{{--    methods: {--}}
{{--        getChecklist() {--}}
{{--            axios.get('./tarefas/checklist')--}}
{{--                .then((response) => {--}}
{{--                    console.log(response.data);--}}
{{--                    this.listaTarefa = response.data;--}}
{{--                    console.log(this.listaTarefa.length);--}}
{{--                    this.hello = 'ok';--}}
{{--                })--}}
{{--        },--}}

{{--    }--}}
{{--})--}}
{{--</script>--}}
@endsection
