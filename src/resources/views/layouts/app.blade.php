<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @component('layouts.app.head', ['page' => $page])@endcomponent
    @yield('js')
</head>
<body>
<header class="header"></header>
<main class="content">
    <div class="container">
        @yield('content')
    </div>
</main>
<footer class="footer"></footer>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/jquery.min.js') }}"></script>
<script src="{{ mix('js/bootstrap.min.js') }}"></script>
<script src="{{ mix('js/vue-bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
