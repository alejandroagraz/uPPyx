<div class="row">
    <div class="panel">
        <form class="form-horizontal" method="POST" action="{{ url('/custom-dashboard') }}">
            <div class="col-md-offset-3 col-md-4">
                @if(isset($filterSelected))
                    <input type="hidden" name="filterSelected" id="filterSelected" value="{{$filterSelected}}">
                @else
                    <input type="hidden" name="filterSelected" id="filterSelected" value="">
                @endif
            </div>
            <div class="input-group space-bottom col-md-5">
                <input type="hidden" name="startDate" id="startDate" value="{{$startDate}}">
                @if(isset($fromOrig) && isset($toOrig))
                    <input type="hidden" name="from" id="from" value="{{$fromOrig}}">
                    <input type="hidden" name="to" id="to" value="{{$toOrig}}">
                @else
                    <input type="hidden" name="from" id="from" value="{{date("Y-m-d")}}">
                    <input type="hidden" name="to" id="to" value="{{date("Y-m-d")}}">
                @endif

                @if(isset($daterange))
                    <input type="hidden" name="dateRangeFilter" id="dateRangeFilter" value="{{$filterSelected. ' | '.$daterange}}">
                @else
                    <input type="hidden" name="dateRangeFilter" id="dateRangeFilter" value="Filtrar por...">
                @endif
                <input class="date-custom" type="text" id="daterange" name="daterange" value="">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-dashboard"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon"><i class="fa fa-phone"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Servicios solicitados</span>
                    <span class="info-box-number">{{$requests}}</span>

                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon"><i class="fa fa-check-circle"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Servicios completados</span>
                    <span class="info-box-number">{{$requestsCompleted}}</span>

                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Clientes registrados</span>
                    <span class="info-box-number">{{$users}}</span>

                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid space-top">
        <div class="col-md-5 col-md-offset-1">
            <div class="info-box">
                <span class="info-box-icon"><i class="fa fa-car"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Carros en servicio<i class="fa fa-plus pull-right font-adjust" data-toggle="modal" data-target="#modalService"></i></span>
                    <span class="info-box-number">{{$requestsOn}}</span>

                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="info-box">
                <span class="info-box-icon"><i class="fa fa-road"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Alquileres contratados<i class="fa fa-plus pull-right font-adjust" data-toggle="modal" data-target="#modalDays"></i></span>
                    <span class="info-box-number">{{$requestsDays}}</span>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalService" tabindex="-1" role="dialog" aria-labelledby="modalServiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalServiceLabel">Carros en Servicio por Agencia</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="tblGrid">
                        <thead id="tblHead">
                        <tr>
                            <th>Agencia</th>
                            <th class="text-center">Cantidad (Carros)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($requestsOnAgency) > 0)
                            @foreach($requestsOnAgency as $requestOn)
                                <tr>
                                    <td>{{$requestOn->takenByAgency->name}}</td>
                                    <td class="text-center">{{$requestOn->total}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan=2 class="text-center">No se encuentran registros</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDays" tabindex="-1" role="dialog" aria-labelledby="modalDaysLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalDaysLabel">Días de Aquiler Contratados por Agencia</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="tblGrid">
                        <thead id="tblHead">
                        <tr>
                            <th>Agencia</th>
                            <th class="text-center">Cantidad (Días)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($requestsDaysAgency) > 0)
                            @foreach($requestsDaysAgency as $requestDays)
                                <tr>
                                    <td>{{$requestDays->takenByAgency->name}}</td>
                                    <td class="text-center">{{$requestDays->total_days}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan=2 class="text-center">No se encuentran registros</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts-extras')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn-dashboard').click(function(){
                if($('#daterange').val() === 'Filtrar por...'){
                    alert("Todos los campos son obligatorios");
                    return false;
                }
            });

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                        "autoclose": true,
                        "autoApply": true,
                        "dateLimit": { days: 365 },
                        "maxDate": new Date(),
                        "opens": "left",
                        "ranges": {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
                            'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
                            'Mes Corriente': [moment().startOf('month'), moment().endOf('month')],
                            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                            'Todos': [$('#startDate').val(), moment()]
                        },
                        "locale": {
                            "format": "DD/MM/YYYY",
                            "separator": " - ",
                            "applyLabel": "Aplicar",
                            "cancelLabel": "Cancelar",
                            "fromLabel": "Desde",
                            "toLabel": "Hasta",
                            "customRangeLabel": "Personalizado",
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
                        $('#from').val(start.format('YYYY-MM-DD'));
                        $('#to').val(end.format('YYYY-MM-DD'));
                    }
                );
                $('input[name="daterange"]').val($('#dateRangeFilter').val());
            });

            $(".date-custom").click(function() {
                $("li").click(function() {
                    $('#filterSelected').val($(this).data('range-key'));
                });
            });
        })
    </script>
@endsection