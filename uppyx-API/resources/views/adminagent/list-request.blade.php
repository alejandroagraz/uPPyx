@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="active customer-title pull-left">Lista de request</li>
    </ol>

    @if (session('status'))
        <p class="padding-top-msj msj-{{ Session::get('message_type') }}"><i class="fa fa-check-circle msj-{{ Session::get('message_type') }}" aria-hidden="true"></i> {{ Session::get('status') }}</p>
    @endif

    @foreach($errors->rental->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    <div class="col-md-12 filter-top">
        @php
            $url = Storage::disk('s3')->url('userProfile');
        @endphp
        <input type="hidden" value="{{ $url }}" id="url-profile">
        <input type="hidden" value="{{url('log-detail')}}" id="url-ajax-detail">
        <input type="hidden" value="{{ asset('images/default-300x300.png') }}" id="url-default">
        <div class="col-md-11">
            <div class="col-md-4 filter-border filter-status">
                <h4 class="filter-title">Estatus</h4>
                <select class="statuses-list" id="statuses" name="statuses[]" multiple="multiple">
                    @foreach($statuses as $status)
                        <option value="{{$status}}">{{$status}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 filter-border">
                <h4 class="filter-title">Día / Costo / Fecha Creación</h4>
                <div class="row">
                    <input type="hidden" id="min" name="min" value="1">
                    <input type="hidden" id="max" name="max" value="21">
                    <div class="col-md-1">
                        <label class="slider-filter-legend" id="label-min">1d</label>
                    </div>
                    <div class="col-md-9 slider-filter">
                        <input id="slider-uppyx" type="text" data-slider-min="1" data-slider-max="21"
                               data-slider-step="1" data-slider-value="[1,21]"/>
                    </div>
                    <div class="col-md-1">
                        <label class="slider-filter-legend slider-filter-legend-right" id="label-max">21d</label>
                    </div>
                </div>

                <div class="row filter-top">
                    <input type="hidden" id="min-cost" name="min-cost" value="1">
                    <input type="hidden" id="max-cost" name="max-cost" value="{{$maxTotalCost+1}}">
                    <div class="col-md-1">
                        <label class="slider-filter-legend" id="label-min-cost">$1</label>
                    </div>
                    <div class="col-md-9 slider-filter">
                        <input id="slider-uppyx-cost" type="text" data-slider-min="1" data-slider-max="{{$maxTotalCost+1}}"
                               data-slider-step="1" data-slider-value="[1,{{$maxTotalCost+1}}]"/>
                    </div>
                    <div class="col-md-1">
                        <label class="slider-filter-legend slider-filter-legend-right" id="label-max-cost">${{$maxTotalCost+1}}</label>
                    </div>
                </div>
                <input type="hidden" name="from" id="from" value="">
                <input type="hidden" name="to" id="to" value="">
                <input class="date-custom date-filter" type="text" id="daterange" name="daterange" value=""/>
            </div>

            <div class="col-md-4 filter-border">
                <h4 class="filter-title">Fechas (Entrega - Devolución)</h4>
                <input type="hidden" name="pickup_date_from" id="pickup_date_from" value="">
                <input type="hidden" name="pickup_date_to" id="pickup_date_to" value="">
                <input class="date-custom date-filter" type="text" id="pickup_daterange" name="pickup_daterange"
                       value=""/>
                <input type="hidden" name="dropoff_date_from" id="dropoff_date_from" value="">
                <input type="hidden" name="dropoff_date_to" id="dropoff_date_to" value="">
                <input class="date-custom date-filter" type="text" id="dropoff_daterange" name="dropoff_daterange"
                       value=""/>
            </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-filter" id="searchData"><i class="glyphicon glyphicon-search"></i></button>
        </div>
    </div>

    <div class="col-lg-12">
        <h3 class="pull-left font-bold customer-title">Lista de solicitudes</h3>
    </div>
    <div class="col-md-12 margin-datatable">
        <table id="tableRequest" class="table table-bordered table-striped responsive nowrap table-request">
            <thead>
            <tr>
                <th>ID</th>
                <th>Estatus</th>
                <th>Solicitado por</th>
                <th>Agencia</th>
                <th>Fecha de creación</th>
                <th>Fecha de entrega</th>
                <th>Fecha de devolución</th>
                <th>Clasificación</th>
                <th>Costo</th>
                <th>Días</th>
                <th>Gerente</th>
                <th>Dirección de entrega</th>
                <th>Dirección de devolución</th>
                <th>Agente</th>
                <th class="width-action text-center all">- -</th>
            </tr>
            </thead>
            <tbody>
                <!-- Contenido DataTable -->
            </tbody>
        </table>
    </div>
    <!-- /.box -->

    <!-- Modal -->
    <div class="modal fade" id="modalService" tabindex="-1" role="dialog" aria-labelledby="modalServiceLabel"
         aria-hidden="true">
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
        $(document).ready(function () {
            /* --- Filter created_at --- */
            $('#daterange').daterangepicker({
                    "maxDate": new Date(),
                    "autoUpdateInput": false,
                    "timePicker": true,
                    "timePickerIncrement": 10,
                    "locale": {
                        "format": "DD-MM-YYYY H:mm",
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
                }, function (start, end) {
                    $('#daterange').val(start.format('DD-MM-YYYY H:mm') + " - " + end.format('DD-MM-YYYY H:mm'));
                    $('#from').val(start.format('YYYY-MM-DD H:mm'));
                    $('#to').val(end.format('YYYY-MM-DD H:mm'));
                }
            );
            $('#daterange').val('Rango desde/hasta');
            // Clean daterange
            $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
                $('#daterange').val('Rango desde/hasta');
                $('#from').val('');
                $('#to').val('');
            });
            // Apply daterange
            $('#daterange').on('apply.daterangepicker', function (ev, picker) {
                $('#daterange').val(start.format('DD-MM-YYYY H:mm') + " - " + end.format('DD-MM-YYYY H:mm'));
                $('#from').val(start.format('YYYY-MM-DD H:mm'));
                $('#to').val(end.format('YYYY-MM-DD H:mm'));
            });
            /* --- Filter created_at --- */

            /* --- Filter pickup_date --- */
            $('#pickup_daterange').daterangepicker({
                    "autoUpdateInput": false,
//                    "minDate": new Date(),
                    "timePicker": true,
                    "timePickerIncrement": 10,
                    "locale": {
                        "format": "DD-MM-YYYY H:mm",
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
                }, function (start, end) {
                    $('#pickup_daterange').val(start.format('DD-MM-YYYY H:mm') + " - " + end.format('DD-MM-YYYY H:mm'));
                    $('#pickup_date_from').val(start.format('YYYY-MM-DD H:mm'));
                    $('#pickup_date_to').val(end.format('YYYY-MM-DD H:mm'));
                }
            );
            $('#pickup_daterange').val('Rango desde/hasta');
            // Clean pickup_daterange
            $('#pickup_daterange').on('cancel.daterangepicker', function (ev, picker) {
                $('#pickup_daterange').val('Rango desde/hasta');
                $('#pickup_date_from').val('');
                $('#pickup_date_to').val('');
            });
            // Apply pickup_daterange
            $('#pickup_daterange').on('apply.daterangepicker', function (ev, picker) {
                $('#pickup_daterange').val(start.format('DD-MM-YYYY H:mm') + " - " + end.format('DD-MM-YYYY H:mm'));
                $('#pickup_date_from').val(start.format('YYYY-MM-DD H:mm'));
                $('#pickup_date_to').val(end.format('YYYY-MM-DD H:mm'));
            });
            /* --- Filter pickup_date --- */

            /* --- Filter dropoff_date --- */
            $('#dropoff_daterange').daterangepicker({
                    "autoUpdateInput": false,
//                    "minDate": new Date(),
                    "timePicker": true,
                    "timePickerIncrement": 10,
                    "locale": {
                        "format": "DD-MM-YYYY H:mm",
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
                }, function (start, end) {
                    $('#dropoff_daterange').val(start.format('DD-MM-YYYY H:mm') + " - " + end.format('DD-MM-YYYY H:mm'));
                    $('#dropoff_date_from').val(start.format('YYYY-MM-DD H:mm'));
                    $('#dropoff_date_to').val(end.format('YYYY-MM-DD H:mm'));
                }
            );
            $('#dropoff_daterange').val('Rango desde/hasta');
            // Clean dropoff_daterange
            $('#dropoff_daterange').on('cancel.daterangepicker', function (ev, picker) {
                $('#dropoff_daterange').val('Rango desde/hasta');
                $('#dropoff_date_from').val('');
                $('#dropoff_date_to').val('');
            });
            // Apply dropoff_daterange
            $('#dropoff_daterange').on('apply.daterangepicker', function (ev, picker) {
                $('#dropoff_daterange').val(start.format('DD-MM-YYYY H:mm') + " - " + end.format('DD-MM-YYYY H:mm'));
                $('#dropoff_date_from').val(start.format('YYYY-MM-DD H:mm'));
                $('#dropoff_date_to').val(end.format('YYYY-MM-DD H:mm'));
            });
            /* --- Filter dropoff_date --- */

            // Init Slider
            $('#slider-uppyx').slider({});
            $("#slider-uppyx").on("slide", function(slideEvt) {
                $("#min").val(slideEvt.value[0]);
                $("#max").val(slideEvt.value[1]);

                $("#label-min").text(slideEvt.value[0]+"d");
                $("#label-max").text(slideEvt.value[1]+"d");
            });
            $('#slider-uppyx-cost').slider({});
            $("#slider-uppyx-cost").on("slide", function(slideEvt) {
                $("#min-cost").val(slideEvt.value[0]);
                $("#max-cost").val(slideEvt.value[1]);

                $("#label-min-cost").text("$"+slideEvt.value[0]);
                $("#label-max-cost").text("$"+slideEvt.value[1]);
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

                $(".statuses-list").select2({
                    placeholder: "Seleccionar estatus",
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
            $('#tableRequest').DataTable({
                "initComplete": function(settings, json) {
                    $('#tableRequest').show();
                },
                dom: 'ftr<"row"<"col-sm-12"i><"col-sm-12"p>>',
                "responsive": true,
                "processing": true,
//                "serverSide": true,
                "destroy": true,
                "ajax": {
                    "url" : "{{ route('rentalData') }}",
                    "type" : "GET",
                    "data" : {
                        "min": $('#min').val(),
                        "max": $('#max').val(),
                        "min_cost": $('#min-cost').val(),
                        "max_cost": $('#max-cost').val(),
                        "from": $('#from').val(),
                        "to": $('#to').val(),
                        "pickup_date_from": $('#pickup_date_from').val(),
                        "pickup_date_to": $('#pickup_date_to').val(),
                        "dropoff_date_from": $('#dropoff_date_from').val(),
                        "dropoff_date_to": $('#dropoff_date_to').val(),
                        "statuses": $('#statuses').val(),
                        "agency_id": $('#agency_id').val()
                    },
                    "dataSrc": function (json) {
                        var data = new Array();
                        for (var i = 0; i < json.data.length; i++) {
                            var requestData = getData(json.data[i]);
                            data.push({
                                'id': requestData.id,
                                'status': requestData.status,
                                'requested_by': requestData.requestedBy,
                                'taken_by_agency': requestData.takenByAgency,
                                'created_at': requestData.createdAt,
                                'pickup_date': requestData.pickUpDate,
                                'dropoff_date': requestData.dropOffDate,
                                'classification': requestData.classification,
                                'total_cost': requestData.totalCost,
                                'total_days': requestData.totalDays,
                                'taken_by_manager': requestData.takenByManager,
                                'pickup_address': requestData.pickUpAddress,
                                'dropoff_address': requestData.dropOffAddress,
                                'taken_by_user': requestData.takenByUser,
                            })
                        }
                        return data;
                    }
                },
                "paging": true,
                "pagingType": "numbers",
                "pageLength": 10,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "order": [[ 5, "desc" ]],
                "info": true,
                "autoWidth": false,
                "columns":[
                    {data: 'id', name: 'rental_requests.id'},
                    {data: 'status', name: 'rental_requests.status'},
                    {data: 'requested_by', name: 'requestedBy.name', "defaultContent": "- -"},
                    {data: 'taken_by_agency', name: 'takenByAgency.name', "defaultContent": "- -"},
                    {data: 'created_at', name: 'rental_requests.created_at'},
                    {data: 'pickup_date', name: 'rental_requests.pickup_date'},
                    {data: 'dropoff_date', name: 'rental_requests.dropoff_date'},
                    {data: 'classification', name: 'classification.description', "defaultContent": "- -"},
                    {data: 'total_cost', name: 'rental_requests.total_cost'},
                    {data: 'total_days', name: 'rental_requests.total_days'},
                    {data: 'taken_by_manager', name: 'takenByManager.name', "defaultContent": "- -"},
                    {data: 'pickup_address', name: 'rental_requests.pickup_address'},
                    {data: 'dropoff_address', name: 'rental_requests.dropoff_address'},
                    {data: 'taken_by_user', name: 'takenByUser.name', "defaultContent": "- -"},
                    {
                        data: null, defaultContent: "<a id='detail-modal' name='detail-modal' data-toggle='tooltip' " +
                    "class='btn btn-blue btn-xs detalles detail-modal'>" +
                    "<i class='btn-log fa fa-search'></i></a>", orderable: false, searchable: false
                    }
                ],
                "columnDefs": [
                    {orderable: false, targets: -1},
                    {visible: false, targets: [0]},
                    { className: "dt-body-center", "targets": [ 14 ] },
                    {
                        "render": function (data) {
                            var costo = "$" + data;
                            return costo;
                        },
                        "targets": 8
                    },
                    {
                        "render": function (data) {
                            var costo = data + " d";
                            return costo;
                        },
                        "targets": 9
                    },
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
        });

        $('#tableRequest').on('click', 'a', function () {
            var element = $(this);
            $('.detail-modal').attr('disabled', true);
            $(this).find('.btn-log').removeClass("fa-search")
            $(this).find('.btn-log').addClass('fa-cog fa-spin');
            var row = $(this).closest("tr");
            var table = row.closest('table').DataTable();
            var data = table.row($(this).parents('tr')).data();
            $.ajax({
                type: 'GET',
                url: $('#url-ajax-detail').val(),
                data: {
                    'id': data.id
                },
                success: function (response) {
                    $('.detail-modal').attr('disabled', false);
                    element.find('.btn-log').removeClass("fa-spin");
                    element.find('.btn-log').removeClass("fa-cog").addClass('fa-search');
                    $('.timeline>li').remove();
                    if (response.length > 0) {
                        var html = '';
                        $.each(response, function (i, data) {
                            if (i % 2 == 0) {
                                html += '<li>';
                            } else {
                                html += '<li class="timeline-inverted">';
                            }
                            if (data.users.profile_picture != null) {
                                html += '<div class="timeline-badge"><img class="img-badge" src=' + $('#url-profile').val() + '/' + data.users.profile_picture + '></div>';
                            } else {
                                html += '<div class="timeline-badge"><img class="img-badge"  src=' + $('#url-default').val() + '></div>';
                            }
                            html += '<div class="timeline-panel">';
                            html += '<div class="timeline-heading">';
                            html += '<h4 class="timeline-title">' + data.log_types.description + '</h4>';
                            html += '<p><span class="text-muted"><i class="glyphicon glyphicon-time"></i>&nbsp;' + data.created_at + '</span></p>';
                            html += '<p><span class="text-muted"><i class="glyphicon glyphicon-user"></i>&nbsp;' + data.users.name + '</span></p>';
                            html += '</div>';
                            html += '<div class="timeline-body">';
                            html += '<p>' + data.message + '</p>';
                            html += '</div>';
                            html += '</div>';
                            html += '<li>';

                        });
                        $('.timeline').append(html);
                    }
                    else {
                        var html = '';
                        html += '<h3 class="text-center timeline-msg not-found-label">' + "No se encuentran registros" + '</h3>';
                        $('.not-found-label').remove();
                        $('.modal-body>.col-md-12').append(html);
                    }

                    $("#modalService").modal('show');
                }
            });
        });

        function getData(object) {
            var data = {
                id: object.id,
                status: object.status,
                requestedBy: (object.requested_by != null) ? object.requested_by.name : "- -",
                takenByAgency: (object.taken_by_agency != null) ? object.taken_by_agency.name : "- -",
                takenByUser: getAgent(object),
                pickUpDate: object.full_pickup_date,
                dropOffDate: getDropoffDate(object),
                classification: (object.classification != null) ? object.classification.description : "- -",
                totalCost: getTotalCost(object),
                totalDays: getTotalDays(object),
                takenByManager: (object.taken_by_manager != null) ? object.taken_by_manager.name : "- -",
                pickUpAddress: object.pickup_address,
                dropOffAddress: getDropoffAddress(object),
                createdAt: object.full_created_at,
            }
            return data
        }

        function getAgent(object) {
            var agentUser;
            if (object.taken_by_user_drop_off != null) {
                agentUser = object.taken_by_user_drop_off.name;
            } else if (object.taken_by_user != null) {
                agentUser = object.taken_by_user.name;
            } else {
                agentUser = "- -";
            }
            return agentUser;
        }

        function getDropoffDate(object) {
            var lastExtension = getLastExtension(object);
            var dropOffDate;
            if (!jQuery.isEmptyObject(lastExtension)) {
                dropOffDate = lastExtension.full_dropoff_date;
            } else {
                dropOffDate = object.full_dropoff_date;
            }
            return dropOffDate;
        }

        function getTotalCost(object) {
            var lastExtension = getLastExtension(object);
            var totalCost;
            if (!jQuery.isEmptyObject(lastExtension)) {
                totalCost = lastExtension.total_cost;
            } else {
                totalCost = object.total_cost;
            }
            return totalCost;
        }

        function getTotalDays(object) {
            var lastExtension = getLastExtension(object);
            var totalDays;
            if (!jQuery.isEmptyObject(lastExtension)) {
                totalDays = lastExtension.total_days;
            } else {
                totalDays = object.total_days;
            }
            return totalDays;
        }

        function getDropoffAddress(object) {
            var lastExtension = getLastExtension(object);
            var dropOffAddress;
            if (!jQuery.isEmptyObject(lastExtension)) {
                dropOffAddress = lastExtension.dropoff_address;
            } else {
                dropOffAddress = object.dropoff_address;
            }
            return dropOffAddress;
        }

        function getLastExtension(object) {
            var lastExtension;
            if (object.rental_request_extensions.length > 0) {
                var extensions = object.rental_request_extensions;
                extensions.sort(function (a, b) {
                    return new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
                });
                lastExtension = extensions[0];
            } else {
                lastExtension = {};
            }
            return lastExtension;
        }
    </script>
@endsection