@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="active">Listar rental rates</li>
            <li><a href="{{ route('rates.create') }}">Registrar nuevo rate</a><li>
        </ol>

        @if (session('status'))
            <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
        @endif

        @foreach($errors->rates->all() as $error) {{-- TODO: rates goes in validator --}}
        <li>{{ $error }}</li>
        @endforeach

        <div class="col-lg-12">
            <h3 class="pull-left font-bold customer-title">Lista de tarifas por vehículo</h3>
        </div>
        <div class="col-md-12 margin-datatable">
            <table id="tableRates" class="table table-bordered table-striped responsive hidden">
                <thead>
                <tr>
                    <th>Tipo de vehículo</th>
                    <th>País</th>
                    <th>Ciudad</th>
                    <th>Días</th>
                    <th>Válido desde / hasta</th>
                    <th>Costo</th>
                    <th class="width-action text-center">- -</th>
                </tr>
                </thead>
                <tbody>
                @if(count($rates)>0)
                    @foreach($rates as $rate)
                        <tr>
                            <td>{{$rate->carRate->description}}</td>
                            <td>{{$rate->countryRate->name}}</td>
                            @if($rate->city_id == null)
                                <td>Todas las Ciudades</td>
                            @else
                                <td>{{$rate->cityRate->name}}</td>
                            @endif
                            <td>{{$rate->days_from}} - {{$rate->days_to}} d</td>
                            <td>{{ date("d-m-Y", strtotime($rate->valid_from)) }} / {{ date("d-m-Y", strtotime($rate->valid_to)) }}</td>
                            <td>${{$rate->amount}}</td>
                            <td>
                                <a href="{{ route('rates.edit', $rate->id) }}" data-toggle="tooltip" class="btn btn-blue btn-xs actualizar"><i class="fa fa-pencil"></i></a>
                                <a href="{{ route('rates.destroy', $rate->id) }}" onclick="return confirm('¿Está seguro que desea eliminar esta Tarifa?')" class="btn btn-blue btn-xs eliminar"><i class="fa fa-trash"></i></a>
                                <img class="adjust-edge" src="{{ asset('images/separator.png') }}">
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
            $('#tableRates').DataTable({
                dom: 'ft<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "initComplete": function() {
                    $('#tableRates').removeClass('hidden');
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
                    { width: 120, targets: 0},
                    { width: 100, targets: 1},
                    { width: 100, targets: 2},
                    { width: 50, targets: 3},
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
