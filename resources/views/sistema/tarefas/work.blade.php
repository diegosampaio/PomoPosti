@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Vamos lá!?</div>
                    <div class="card-body">
                        @if($tarefa->statusTarefa != 3)
                            <div class="timer" id="timer">
                                <span id="hora">00</span>:<span id="minuto">00</span>:<span id="segundo">00</span>
                            </div>
                            <div class="msgReturn"></div>
                        @else
                            <div class="text-center">
                                <h1 class="text-success"><i class="fas fa-check"></i></h1>
                                <h2>Finalizada em <span>{{ date('d/m/Y H:i:s', strtotime($tarefa->dataFinalizacao)) }}</span></h2>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-block btn-outline-info btnPlay" @if($tarefa->statusTarefa == 1) style="display: none" @endif onclick="getPlay()"><i class="fas fa-play"></i> Iniciar</button>
                        <button type="button" class="btn btn-block btn-outline-danger btnStop"  @if($tarefa->statusTarefa == 1) style="display: inline" @else style="display: none" @endif style="display: none" onclick="getStop()"><i class="fas fa-stop"></i> Parar</button>
                        <button type="button" class="btn btn-block btn-outline-success btnFinish" onclick="getFinish()"><i class="fas fa-check"></i> Finalizar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dados da sua Tarefa</div>
                    <div class="card-body">
                        <b>O que você deve fazer:</b> <br />
                        {{ $tarefa->tituloTarefa }}


                        @if($tarefa->prazo)
                            <br /><br />
                            Você tem até o dia <b>{{ date('d/m/Y', strtotime($tarefa->prazo)) }}</b> para resolver isso!
                        @endif

                        @if($tarefa->categorias_id)
                            <br /><br />
                            <span class="badge badge-info">
                                <i class="fas fa-tag"></i>
                                {{ $tarefa->categoria->tituloCategoria }}
                            </span>

                        @endif

                        @if($tarefa->observacoes)
                            <hr />
                            <b>Observações:</b> <br />
                            {!! $tarefa->observacoes !!}
                        @endif
                        <hr />
                        <div class="text-right">
                                <a href="javascript:void()" class="badge badge-danger" data-toggle="modal" data-target="#delReg">
                                    <i class="fas fa-trash"></i> Tarefa
                                </a>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="work-tab" data-toggle="tab" href="#work" role="tab" aria-controls="work" aria-selected="true">
                                    <i class="fas fa-user-clock"></i> Ciclos de Trabalho
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">
                                    <i class="fas fa-comments"></i> Comentários
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="work" role="tabpanel" aria-labelledby="work-tab">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ciclo</th>
                                            <th>Inicio</th>
                                            <th>Fim</th>
                                            <th>Total Trabalhado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tblCiclos"></tbody>
                                </table>
                            </div><!--#work-->
                            <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Comentário</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($comentarios as $com)
                                        <tr>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($com->created_at)) }}</td>
                                            <td>{{ $com->comentarios }}</td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">Não há comentários registrados.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div><!--#comments-->
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="mldFinish" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tarefas.finish') }}" method="post">
            {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Finalizar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="txtComentario">Deseja registrar algum comentário?</label>
                    <textarea name="comentario" id="txtComentario" class="form-control"placeholder="Opcional"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Finalizar</button>
                <input type="hidden" name="trf" value="{{ $tarefa->id }}" />
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mldComentario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tarefas.storeComments') }}" method="post">
            {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar Comentário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="txtComentario">Deseja registrar algum comentário?</label>
                    <textarea name="comentario" id="txtComentario" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não Registrar</button>
                <button type="submit" class="btn btn-success">Registrar</button>
                <input type="hidden" name="trf" value="{{ $tarefa->id }}" />
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delReg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tarefas.lixeira') }}" method="post">
            {{ csrf_field() }}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deletar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <b>Atenção!</b> Deseja realmente excluir esta tarefa? Após essa confirmação a mesma não poderá ser
                    desfeita.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                <input type="hidden" name="trf" value="{{ $tarefa->id }}" />
            </div>
        </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdlAviso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hora do Descanço</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <b>Atenção!</b> Tire um tempo para recuperar as energias, lembre-se de que dos ciclos de trabalho de
                1 à 3 pomodoris você deve ter 5 minutos de intervalo, acima de 4 pomodoris seu intervalo deve ser de
                15 à 30 minutos.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function(){
    getCiclos();
});

function getPlay(){
    $('.btnPlay').css('display', 'none');
    $('.btnStop').css('display', 'inline');
    $('.btnFinish').css('display', 'none');
    getUp('play');
    tempo(1);
}
function getStop(){
    $('.btnPlay').css('display', 'inline');
    $('.btnStop').css('display', 'none');
    $('.btnFinish').css('display', 'inline');
    $('#mldComentario').modal('show');
    getUp('stop');
    parar();
    limpa();
}
function getFinish(){
    $('.btnPlay').css('display', 'none');
    $('.btnStop').css('display', 'none');
    $('.btnFinish').css('display', 'none');
    $('#mldFinish').modal('show');
}
function getUp(action){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {'trf': {{ $tarefa->id }}, 'action': action},
        url: "{{ route('tarefas.update') }}",
        beforeSend: function(){
            $('.msgReturn').html('Atualizando dados...');
        },
        success: function(response){
            $('.msgReturn').html('');
            toast(response);
            getCiclos();
        },
        error: function(){
            $('.msgReturn').html('');
            toast('Ops! Houve um erro, atualize a página e tente novamente.');
        }
    });
}
function getCiclos(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {'trf': {{ $tarefa->id }} },
        url: "{{ route('tarefas.ciclos') }}",
        beforeSend: function(){
            $('.tblCiclos').html('<tr><td colspan="4">Atualizando dados...</td></tr>');
        },
        success: function(response){
            $('.tblCiclos').html(response);
        },
        error: function(){
            $('.tblCiclos').html('<tr><td colspan="4">Ops! Erro ao carregar dados, atualize sua página.</td></tr>');
        }
    });
}

var intervalo;

function tempo() {
    var timer;
    var tH;
    var tM;
    var tS;
    var s = 1;
    var m = 0;
    var h = 0;
    intervalo = window.setInterval(function() {
        if (s == 60) { m++; s = 0; }
        if (m == 60) { h++; s = 0; m = 0; }
        // if (h < 10) document.getElementById("hora").innerHTML = "0" + h; else document.getElementById("hora").innerHTML = h ;
        // if (s < 10) document.getElementById("segundo").innerHTML = "0" + s; else document.getElementById("segundo").innerHTML = s;
        // if (m < 10) document.getElementById("minuto").innerHTML = "0" + m; else document.getElementById("minuto").innerHTML = m;
        if (h < 10) tH = "0" + h; else tH = h ;
        if (s < 10) tS = "0" + s; else tS = s;
        if (m < 10) tM = "0" + m; else tM = m;
        timer = tH + ":" + tM + ":" + tS;
        document.getElementById("timer").innerHTML = timer;
        document.title = timer + ' | POMOtask';

        if (m == 25 && s == 0) {
            var audio = new Audio('{{ asset("sound/alarme.mp3") }}');
            audio.addEventListener('canplaythrough', function() {
                audio.play();
            });
            $('#mdlAviso').modal('show');
        }

        s++;
    },1000);
}

function parar() {
    window.clearInterval(intervalo);
}


function limpa() {
    document.getElementById('timer').innerHTML = "<span id=\"hora\">00</span>:<span id=\"minuto\">00</span>:<span id=\"segundo\">00</span>";
}

function toast(msg){
    const toast = '<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">\n' +
                  '  <div class="toast-header">\n' +
                  '    <strong class="mr-auto">Bootstrap</strong>\n' +
                  '    <small class="text-muted">just now</small>\n' +
                  '    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
                  '      <span aria-hidden="true">&times;</span>\n' +
                  '    </button>\n' +
                  '  </div>\n' +
                  '  <div class="toast-body">\n' +
                        msg
                  '  </div>\n' +
                  '</div>';
}
</script>
@endsection
