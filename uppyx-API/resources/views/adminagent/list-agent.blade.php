@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="active">Listar agentes</li>
        <li><a href="{{ url('/register-agent') }}">Registrar agente</a></li>
    </ol>

    @if (session('status'))
        <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
    @endif

    @foreach($errors->rental->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    <div class="col-lg-12">
        <h3 class="pull-left font-bold customer-title">Lista de agentes</h3>
    </div>
    <div class="col-md-12 margin-datatable">
        <table id="tableAgent" class="table table-bordered table-striped responsive hidden">
            <thead>
            <tr>
                <th>Agente</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th class="width-action text-center">- -</th>
            </tr>
            </thead>
            <tbody>
            @if(count($users)>0)
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td class="widthTable">{{$user->address}}</td>
                        <td>{{$user->phone}}</td>
                        @if($user->status == 1)
                            <td><span class="label span11">Activo</span></td>
                        @else
                            <td><span class="label span12">Inhabilitado</span></td>
                        @endif
                        <td>
                            <a href="{{url('/update-agent/'.$user->id)}}" data-toggle="tooltip" class="btn btn-blue btn-xs actualizar"><i class="fa fa-pencil"></i></a>
                            @if ($user->status == 1)
                                <a href="{{url('/disable-agent/'.$user->id)}}" data-toggle="tooltip"class="btn btn-blue btn-xs inhabilitar"><i class="fa fa-lock" aria-hidden="true"></i></a>
                            @elseif ($user->status == 2)
                                <a href="{{url('/enable-agent/'.$user->id)}}" data-toggle="tooltip" class="btn btn-blue btn-xs habilitar"><i class="fa fa-unlock" aria-hidden="true"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            @endif

            <tfoot>

            </tfoot>
        </table>
    </div>
    <!-- /.box -->
</div>
<!-- /.col -->
@endsection

@section('scripts-extras')
    <script>
        $(document).ready(function () {
            $('#tableAgent').DataTable({
                dom: 'ft<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "initComplete": function(settings, json) {
                    $('#tableAgent').removeClass('hidden');
                },
                "responsive": true,
                "paging": true,
                "pagingType": "numbers",
                "pageLength": 10,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "columnDefs": [
                    { orderable: false, targets: -1 },
                    { className: "dt-body-center", "targets": [ 3,4 ] },
                    { width: 180, targets: 0},
                    { width: 300, targets: 1},
                    { width: 100, targets: 2},
                    { width: 100, targets: 3},
                    { width: 80, targets: 4},
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ],
                "language": {
                    "decimal":        "",
                    "emptyTable":     "No existen registros",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrado de _MAX_ total registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
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
        });
    </script>
    @include('layouts.partials.scriptalert')
@endsection