<!-- Scripts -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Bootstrap Slider-->
<script src="{{ asset('/js/bootstrap-slider.js') }}"></script>

<!-- DataTables 1.10.12-->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.responsive.min.js') }}"></script>

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- iCheck -->
<script src="{{ asset('/js/icheck.min.js') }}"></script>

<!-- MomentJS -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<!-- Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script>
    $(document).ready(function(){
        $('.inhabilitar').tooltip({title: "Inhabilitar", placement: "top"});
        $('.habilitar').tooltip({title: "Habilitar", placement: "top"});
        $('.actualizar').tooltip({title: "Actualizar", placement: "top"});
        $('.eliminar').tooltip({title: "Eliminar", placement: "top"});
        $('.detalles').tooltip({title: "Detalles", placement: "top"});
    });
</script>

<script>
    {{-- Recomendacion de la documentacion--}}
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    <!-- /* window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>*/ -->
</script>

<!--Scripts de la página-->
@yield('scripts-extras')
<!--Fin Scripts de la página-->