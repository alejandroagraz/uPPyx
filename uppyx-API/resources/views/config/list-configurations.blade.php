@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="active">Listar configuraciones</li>
            <li><a href="{{ route('configurations.create') }}">Registrar nueva configuración</a><li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        @foreach($errors->config->all() as $error) {{-- TODO: configuration goes in validator --}}
            <li>{{ $error }}</li>
        @endforeach

        <div class="col-lg-12">
            <h3 class="pull-left font-bold customer-title">Lista de configuraciones del sistema</h3>
        </div>
        <div class="col-md-12 margin-datatable">
            <table id="tableConfigs" class="table table-bordered table-striped responsive hidden">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>País</th>
                    <th>Ciudad</th>
                    <th>Alias</th>
                    <th>Descripción</th>
                    <th>Valor</th>
                    <th class="width-action text-center">- -</th>
                </tr>
                </thead>
                <tbody>
                @if(count($config)>0)
                    @foreach($config as $cfg)
                        <tr>
                            <td>{{$cfg->type}}</td>
                            <td>
                                @if($cfg->country_id == null)
                                    Todos los Paises
                                @else
                                    {{$cfg->countryConfig->name}}
                                @endif
                            </td>
                            @if($cfg->city_id == null)
                                <td>Todas las Ciudades</td>
                            @else
                                <td>{{$cfg->cityConfig->name}}</td>
                            @endif
                            <td>{{$cfg->alias}}</td>
                            <td>{{$cfg->name}}</td>
                            @if($cfg->unit == "$")
                                <td>{{$cfg->unit}}{{$cfg->value}}</td>
                            @else
                                <td>{{$cfg->value}}{{$cfg->unit}}</td>
                            @endif
                            <td>
                                <a href="{{ route('configurations.edit', $cfg->id) }}" data-toggle="tooltip" class="btn btn-blue btn-xs actualizar"><i class="fa fa-pencil"></i></a>
                                @if($cfg->type == "system")
                                    <a class="btn btn-red btn-xs readonly"><i class="fa fa-lock"></i></a>
                                @else
                                    <a href="{{ route('configurations.destroy', $cfg->id) }}" onclick="return confirm('¿Está seguro que desea eliminar esta Configuración?')" class="btn btn-blue btn-xs eliminar"><i class="fa fa-trash"></i></a>
                                @endif
                                <img src="{{ asset('images/separator.png') }}">
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tableConfigs').DataTable({
                dom: 'ft<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "initComplete": function() {
                    $('#tableConfigs').removeClass('hidden');
                },
                "responsive": true,
                "deferRender": true,
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
                    { className: "dt-body-center", "targets": 6 },
                    { width: 100, targets: 0},
                    { width: 140, targets: 1},
                    { width: 100, targets: 2},
                    { width: 100, targets: 3},
                    { width: 200, targets: 4},
                    { width: 80, targets: 5},
                    { width: 80, targets: 6},
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
