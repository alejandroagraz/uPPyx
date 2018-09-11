@extends('layouts.app')

@section('content')
        <div class="container">
            <ol class="breadcrumb">
                <!--li><a href="{{ url('/') }}">Inicio</a></li-->
                <li class="active">Listar usuarios</li>
                <li><a href="{{ url('/register-rental-admin') }}">Registrar usuarios</a><li>
            </ol>

            @if (session('status'))
                <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
            @endif

            @foreach($errors->rental->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

            <div class="col-lg-12">
                <h3 class="pull-left font-bold customer-title">Lista de administradores y gerentes</h3>
            </div>
            <div class="col-md-12 margin-datatable">
                <table id="tableUser_r" class="table table-bordered table-striped responsive hidden">
                    <thead>
                    <tr>
                        <th>Perfil</th>
                        <th>Usuario</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Agencia</th>
                        <th>Estado</th>
                        <th class="width-action text-center">- -</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($users)>0)
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->roles[0]->display_name}}</td>
                                <td>{{$user->name}}</td>
                                @if(empty($user->address))
                                    <td>- -</td>
                                @else
                                    <td class="widthTable">{{$user->address}}</td>
                                @endif
                                @if(empty($user->phone))
                                    <td>- -</td>
                                @else
                                    <td>{{$user->phone}}</td>
                                @endif
                                <td>{{$user->email}}</td>
                                @if(empty($user->rentalAgencies->name))
                                    <td>- -</td>
                                @else
                                    <td>{{$user->rentalAgencies->name}}</td>
                                @endif
                                @if($user->status == 1)
                                    <td><span class="label span11">Activo</span></td>
                                @elseif($user->status == 2)
                                    <td><span class="label span12">Inhabilitado</span></td>
                                @else
                                    <td><span class="label span12">Por Confirmar</span></td>
                                @endif
                                <td>
                                    <span style="width: 90px;"></span>
                                    <a href="{{url('/update-user-rental/'.$user->id)}}" data-toggle="tooltip" class="btn btn-blue btn-xs actualizar"><i class="fa fa-pencil"></i></a>
                                    @if ($user->status == 1)
                                        <a href="{{url('/disable-user-rental/'.$user->id)}}" data-toggle="tooltip" class="btn btn-blue btn-xs inhabilitar"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                    @elseif ($user->status == 2)
                                        <a href="{{url('/enable-user-rental/'.$user->id)}}" data-toggle="tooltip" class="btn btn-blue btn-xs habilitar"><i class="fa fa-unlock" aria-hidden="true"></i></a>
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
    <script>
        $(document).ready(function () {
            $('#tableUser_r').DataTable({
                dom: 'ft<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "initComplete": function(settings, json) {
                    $('#tableUser_r').removeClass('hidden');
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
                    { className: "dt-body-center", "targets": [ 2,3,5,6,7 ] },
                    { width: 50, targets: 0},
                    { width: 20, targets: 1},
                    { width: 20, targets: 2},
                    { width: 20, targets: 3},
                    { width: 20, targets: 4},
                    { width: 20, targets: 5},
                    { width: 20, targets: 6},
                    { width: 100, targets: 7},
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