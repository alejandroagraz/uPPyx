<!DOCTYPE html>
<html lang="es">

@include('layouts.partials.htmlhead')

<body class="body-login">
<div class="wrapper container-fluid" id="app">

<!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
    <!-- /.content -->
    @include('layouts.partials.footer')
</div>

@include('layouts.partials.scripts')
</body>
</html>