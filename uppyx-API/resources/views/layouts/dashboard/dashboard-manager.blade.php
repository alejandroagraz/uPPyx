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
                    <input type="hidden" name="daterangeFilter" id="daterangeFilter" value="{{$filterSelected. ' | '.$daterange}}">
                @else
                    <input type="hidden" name="daterangeFilter" id="daterangeFilter" value="Filtrar por...">
                @endif
                <input class="date-custom" type="text" id="daterange" name="daterange" value="">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-dashboard"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
    </div>

    <div class="container-fluid">
        <div class="col-md-5 col-md-offset-1">
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
        <div class="col-md-5">
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
    </div>
    <div class="container-fluid space-top">
        <div class="col-md-5 col-md-offset-1">
            <div class="info-box">
                <span class="info-box-icon"><i class="fa fa-car"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Carros en servicio</span>
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
                    <span class="info-box-text">Días alquileres contratados</span>
                    <span class="info-box-number">{{$requestsDays}}</span>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
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

                $('input[name="daterange"]').val($('#daterangeFilter').val());
            });

            $(".date-custom").click(function() {
                $("li").click(function() {
                    $('#filterSelected').val($(this).data('range-key'));
//                    console.log('valor='+$(this).data('range-key'));
                });
            });
        })
    </script>
@endsection