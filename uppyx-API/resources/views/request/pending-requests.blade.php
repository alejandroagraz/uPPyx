@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="active customer-title pull-left">Rentas por finalizar</li>
    </ol>

    @if (session('status'))
        <p class="padding-top-msj msj-{{ Session::get('message_type') }}">
            <i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i>
            {{ Session::get('status') }}
        </p>
    @endif

    @foreach($errors->config->all() as $error) {{-- TODO: configuration goes in validator. --}}
        <li>{{ $error }}</li>
    @endforeach

    <div class="col-lg-12">
        <h3 class="pull-left font-bold customer-title">Lista de rentas por finalizar</h3>
    </div>

    <!-- box -->
    <div class="col-md-12 margin-datatable">
        <table id="tableRequest" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Estatus</th>
                <th>Solicitado por</th>
                <th>Email</th>
                <th>Agente</th>
                <th>Fecha de devolución</th>
                <th class="width-action text-center">- -</th>
            </tr>
            </thead>
            <tbody>
            @if(count($rentalRequests) > 0)
                @foreach($rentalRequests as $rentalRequest)
                    <tr>
                        <td>{{$rentalRequest->status}}</td>
                        <td>{{ (count($rentalRequest->requestedBy) > 0) ? $rentalRequest->requestedBy->name : "" }}</td>
                        <td>{{ (count($rentalRequest->requestedBy) > 0) ? $rentalRequest->requestedBy->email : "" }}</td>
                        <td>{{ (count($rentalRequest->takenByUserDropOff) > 0) ? $rentalRequest->takenByUserDropOff->name : "" }}</td>
                        @if(count($rentalRequest->rentalRequestExtensions) > 0)
                            @php
                                $lastExtension = $rentalRequest->rentalRequestExtensions->sortByDesc('created_at')->first();
                            @endphp
                            <td>
                                {{ $lastExtension->full_dropoff_date }}
                            </td>
                        @else
                            <td>
                                {{ $rentalRequest->full_dropoff_date }}
                            </td>
                        @endif
                        <td class="text-center">
                            <a id='confirm-modal' name='confirm-modal' data-toggle="modal" data-target="#modalService"
                               class='btn btn-blue btn-xs confirm-modal' data-uuid="{{$rentalRequest->uuid}}">
                                <i class='btn-log fa fa-lock'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <!-- /.box -->

    <!-- Modal -->
    <div class="modal fade" id="modalService" tabindex="-1" role="dialog" aria-labelledby="modalServiceLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div id="modal-content" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalServiceLabel">Confirmar</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        @if(count($rentalRequests) > 0)
                            <p class="padding-top-msj msj-error colorRedFont" style="display: none" id="div-modal-errors">
                                <i class="fa fa-check-circle msj-error" aria-hidden="true"></i>
                            </p>
                            <div class="alert alert-danger" id="div-modal-errors" style="display: none">
                                <ul></ul>
                            </div>

                            <form class="form-horizontal" method="POST" id="confirm-form"
                                  action="{{ url('/rental-requests') }}" data-url="{{ url('/rental-request-pending') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->rental->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="password" name="password" value="{{old('password')}}" type="password"
                                           class="form-control" placeholder="Contraseña" required>
                                    @if ($errors->has('password'))
                                        <p class="colorRedFont">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input id="email" name="email" value="{{old('email')}}" type="email" class="form-control"
                                           placeholder="Email Cliente" required>
                                    <input id="rental-request-uuid" name="uuid" value="" type="hidden">
                                    @if ($errors->has('email'))
                                        <p class="colorRedFont">
                                            {{ $errors->first('email') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="col-md-6 col-md-offset-3">
                                    <button class="btnSend" type="submit">
                                        <img src="{{ asset('images/send-uPPyx.png') }}" alt="uPPyx">
                                    </button>
                                    <div id="loading-image" style="display:none">
                                        <img src={{ URL::asset('images/loading.gif') }}>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Modal -->
</div>
<!-- /.col -->
@endsection

@section('scripts-extras')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tableRequest').DataTable({
                dom: 'ftr<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "responsive": true,
                "paging": true,
                "pagingType": "numbers",
                "pageLength": 10,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "caseInsensitive": true,
                "info": true,
                "autoWidth": false,
                "columnDefs": [
                    { orderable: false, targets: -1 }
                ],
                "language": {
                    "decimal":        "",
                    "emptyTable":     "No se encuentran registros disponible para el listado de request",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrado de _MAX_ total registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando... <img src={{ URL::asset('images/loading.gif') }}>",
                    "search": "_INPUT_",
                    "searchPlaceholder": "Buscar...",
                    "zeroRecords":    "No hay registros que coinciden con los criterios de búsqueda",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Previa"
                    },
                    "aria": {
                        "sortAscending":  ": activar filtro de columna ascendente",
                        "sortDescending": ": activar filtro de columna descendente"
                    }
                }
            });
            $('.confirm-modal').on("click", function () {
                $("#password").val("");
                $("#email").val("");
                $('#div-modal-errors').html("");
                $('#div-modal-errors').hide();
                var rentalRequestUuid = $(this).data('uuid');
                $("#rental-request-uuid").val(rentalRequestUuid);
            });
            $('#confirm-form').on('submit', function(e){
                e.preventDefault();
                $form = $(this);
                $uuid = $("#rental-request-uuid").val();
                $urlCallback = $form.data('url')
                $url = $form.attr('action')+'/'+$uuid+'/edit';
                $("#loading-image").show();
                $.ajax({
                    url: $url,
                    type: 'POST',
                    data: $('#confirm-form').serialize(),
                    success: function(data) {
                        $("#loading-image").hide();
                        $('#confirm-modal').modal('hide');
                        window.location.href = $urlCallback;
                    },
                    error : function(xhr, status, error) {
                        $("#loading-image").hide();
                        if(xhr.status == 400) {
                            var errors = $.parseJSON(xhr.responseText);
                            var errorString = '';
                            $.each(errors, function(index, value) {
                                errorString =  value;
                            });
                            $('#div-modal-errors').html(errorString);
                            $('#div-modal-errors').show();
                        }
                    },
                });
            });
        });
    </script>
@endsection