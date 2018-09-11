@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="active">Listar cargos</li>
            <li><a href="{{ url('/register-charges') }}">Registrar nuevo cargo</a><li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        @foreach($errors->config->all() as $error) {{-- TODO: configuration goes in validator --}}
        <li>{{ $error }}</li>
        @endforeach

        <div class="col-lg-12">
            <h3 class="pull-left font-bold customer-title">Lista de cargos por vehículo</h3>
        </div>
        <div class="col-md-12 margin-datatable">
            <table id="tableConfigs" class="table table-bordered table-striped responsive hidden">
                <thead>
                <tr>
                    <th>Tipo de vehículo</th>
                    <th>Tipo de cargo</th>
                    <th>Pais</th>
                    <th>Ciudad</th>
                    <th class="width-action text-center">- -</th>
                </tr>
                </thead>
                <tbody>
                @if(count($charges)>0)
                    @foreach($charges as $cfg)
                        <tr>
                            <td>{{(count($cfg->car) > 0) ? $cfg->car->description : ''}}</td>
                            <td>{{(count($cfg->configuration) > 0) ? $cfg->configuration->name : ''}}</td>
                            <td>
                                @if(isset($cfg->configuration->countryConfig->name))
                                    {{$cfg->configuration->countryConfig->name}}
                                @else
                                    Todas los Países
                                @endif
                            </td>
                            <td>
                                @if(isset($cfg->configuration->cityConfig->name))
                                    {{$cfg->configuration->cityConfig->name}}
                                @else
                                    Todas las Ciudades
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/charges/'.$cfg->id.'/destroy')}}"
                                   onclick="return confirm('¿Está seguro que desea eliminar este Cargo?')"
                                   class="btn btn-blue btn-xs eliminar"><i class="fa fa-trash"></i></a>
                                <img src="{{ asset('images/separator.png') }}" style="position: absolute;">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
                <tfoot>
                </tfoot>
            </table>
        </div>

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
                    { className: "dt-body-center", "targets": 4 },
                    { width: 210, targets: 1},
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
