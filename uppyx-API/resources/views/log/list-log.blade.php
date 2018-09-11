@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="active customer-title pull-left">Lista de logs</li>
        </ol>

        <div class="col-md-12 filter-top">
            @php
                $url = Storage::disk('s3')->url('userProfile');
            @endphp
            <input type="hidden" value="{{ $url }}" id="url-profile">
            <input type="hidden" value="{{url('log-detail')}}" id="url-ajax-detail">
            <input type="hidden" value="{{ asset('images/default-300x300.png') }}" id="url-default">
            <div class="col-md-11">
                <div class="col-md-6 filter-border filter-status">
                    <h4 class="filter-title">Tipo</h4>
                    <select class="logs-types" id="logsTypes" name="logsTypes" multiple="multiple">
                        @foreach($logsTypes as $types)
                            <option value="{{$types->id}}">{{$types->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 filter-border">
                    <h4 class="filter-title">Fecha</h4>
                    <input type="hidden" name="from" id="from" value="">
                    <input type="hidden" name="to" id="to" value="">
                    <input class="date-custom date-filter-log" type="text" id="daterange" name="daterange" value="" />
                </div>
            </div>
            <div class="col-md-1">
                <button class="btn btn-filter" id="searchData"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        <div class="col-lg-12">
            <h3 class="pull-left font-bold customer-title">Listado de logs</h3>
        </div>
        <div class="col-md-12 margin-datatable">
            <table id="tableRequest" class="table table-bordered table-striped responsive nowrap table-request">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de log</th>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Car rental</th>
                    <th>Solicitud</th>
                    <th class="width-action text-center">- -</th>
                </tr>
                </thead>
                <tbody>
                    <!-- Contenido DataTable -->
                </tbody>

            </table>
        </div>
        <!-- /.box -->

        <!-- Modal -->
        <div class="modal fade" id="modalService" tabindex="-1" role="dialog" aria-labelledby="modalServiceLabel" aria-hidden="true">
            <div class="modal-dialog modal-log" role="document">
                <div id="modal-content" class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modalServiceLabel">Detalle de Log</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <ul class="timeline">
                                <!-- Contenido Timeline -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
@endsection

@section('scripts-extras')
    <script>
        var row = 0;
        $(document).ready(function () {
            $('#daterange').daterangepicker({
                    "maxDate": new Date(),
                    "autoUpdateInput": false,
                    "locale": {
                        "format": "DD-MM-YYYY",
                        "separator": " - ",
                        "applyLabel": "Aplicar",
                        "cancelLabel": "Limpiar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mie",
                            "Jue",
                            "Vie",
                            "Sab"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },function(start, end) {
                    $('#daterange').val(start.format('DD-MM-YYYY')+" - "+end.format('DD-MM-YYYY'));
                    $('#from').val(start.format('YYYY-MM-DD'));
                    $('#to').val(end.format('YYYY-MM-DD'));
                }
            );
            $('input[name="daterange"]').val('Rango desde/hasta');
            // Clean daterange
            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $('#daterange').val('Rango desde/hasta');
                $('#from').val('');
                $('#to').val('');
            });
            // Apply dropoff_daterange
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $('#daterange').val(start.format('DD-MM-YYYY')+" - "+end.format('DD-MM-YYYY'));
                $('#from').val(start.format('YYYY-MM-DD'));
                $('#to').val(end.format('YYYY-MM-DD'));
            });

            $.fn.select2.amd.require([
                'select2/utils',
                'select2/dropdown',
                'select2/dropdown/attachBody'
            ], function (Utils, Dropdown, AttachBody) {
                function SelectAll() { }

                SelectAll.prototype.render = function (decorated) {
                    var $rendered = decorated.call(this);
                    var self = this;

                    var $selectAll = $(
                        '<button class="select-all" type="button">Seleccionar Todo</button>'
                    );

                    $rendered.find('.select2-dropdown').prepend($selectAll);

                    $selectAll.on('click', function (e) {
                        var $results = $rendered.find('.select2-results__option[aria-selected=false]');

                        // Get all results that aren't selected
                        $results.each(function () {
                            var $result = $(this);

                            // Get the data object for it
                            var data = $result.data('data');

                            // Trigger the select event
                            self.trigger('select', {
                                data: data
                            });
                        });

                        self.trigger('close');
                    });

                    return $rendered;
                };

                $(".logs-types").select2({
                    placeholder: "Seleccione un tipo",
                    allowClear: false,
                    dropdownAdapter: Utils.Decorate(
                        Utils.Decorate(
                            Dropdown,
                            AttachBody
                        ),
                        SelectAll
                    )
                });
            });
        });

        $('#searchData').click(function () {
            $('#tableRequest').hide();
            var table = $('#tableRequest').DataTable({
                "initComplete": function(settings, json) {
                    $('#tableRequest').show();
                    $('.detalles').tooltip({title: "Detalles", placement: "top"});
                },                
                dom: 'ftr<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": {
                    "url" : "{{ route('logData') }}",
                    "type" : "GET",
                    "data" : {
                        "from"  : $('#from').val(),
                        "to"    : $('#to').val(),
                        "types" : $('#logsTypes').val(),
                    }
                },
                "paging": true,
                "pagingType": "numbers",
                "pageLength": 10,
                "lengthChange": false,
                "searching": true,
                "caseInsensitive": true,
                "ordering": true,
                "order": [[ 2, "desc" ]],
                "info": true,
                "autoWidth": false,
                "columns":[
                    {data: 'id' , name: 'logs.id'},
                    {data: 'log_types.description', name:'logTypes.description'},
                    {data: 'created_at2' , name: 'logs.created_at', type: 'dd-mm-yyyy'},
                    {data: 'users.name' , name: 'users.name'},
                    {data: 'rental_agencies.name' , name: 'rentalAgencies.name' , defaultContent: "- -"},
                    {data: 'message' , name: 'logs.message'},
                    {data: null, defaultContent: "<a id='detail-modal' name='detail-modal' data-toggle='tooltip' " +
                        "class='btn btn-blue btn-xs detalles detail-modal'>" +
                        "<i class='btn-log fa fa-search'></i></a>", orderable: false, searchable: false}
                ],
                "columnDefs": [
                    { className: "dt-body-center", "targets": [ 6 ] },
                    { visible: false, targets: [ 0 ] }
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

            $('#tableRequest tbody').on('click', 'tr', function () {
                row = table.row(this).data();
            });

            $('#tableRequest').on( 'click', 'a', function () {
                var element = $(this);
                $('.detail-modal').attr('disabled',true);
                $(this).find('.btn-log').removeClass("fa-search")
                $(this).find('.btn-log').addClass('fa-cog fa-spin');
                $.ajax({
                    type: 'GET',
                    url: $('#url-ajax-detail').val(),
                    data: {
                        'id': row.rental_request_id
                    },
                    success: function(response){
                        $('.detail-modal').attr('disabled',false);
                        element.find('.btn-log').removeClass("fa-spin");
                        element.find('.btn-log').removeClass("fa-cog").addClass('fa-search');
                        $('.timeline>li').remove();
                        if(response.length>0){
                            var html = '';
                            $.each(response, function(i, data){
                                if(i % 2 == 0){
                                    html +='<li>';
                                }else{
                                    html +='<li class="timeline-inverted">';
                                }
                                if(data.users.profile_picture != null) {
                                    html += '<div class="timeline-badge"><img class="img-badge" src='+$('#url-profile').val()+'/'+data.users.profile_picture+'></div>';
                                }else{
                                    html += '<div class="timeline-badge"><img class="img-badge"  src='+$('#url-default').val()+'></div>';
                                }
                                html +='<div class="timeline-panel">';
                                html +='<div class="timeline-heading">';
                                html +='<h4 class="timeline-title">'+data.log_types.description+'</h4>';
                                html +='<p><span class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;'+ data.created_at+'</span></p>';
                                html +='<p><span class="text-muted"><i class="glyphicon glyphicon-user"></i>&nbsp;'+ data.users.name+'</span></p>';
                                html +='</div>';
                                html +='<div class="timeline-body">';
                                html +='<p>'+data.message+'</p>';
                                html +='</div>';
                                html +='</div>';
                                html +='<li>';

                            });
                            $('.timeline').append(html);
                        }
                        else{
                            var html = '';
                            html +='<h3 class="text-center timeline-msg not-found-label">'+"No se encuentran registros"+'</h3>';
                            $('.not-found-label').remove();
                            $('.modal-body>.col-md-12').append(html);
                        }

                        $("#modalService").modal('show');
                    }
                });
            });
        });
    </script>
@endsection