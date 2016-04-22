<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Laravel Quickstart - Basic</title>

        <!-- CSS And JavaScript -->
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-default">
                <!-- Navbar Contents -->
            </nav>
        </div>

       <!--special Blade directive that specifies where all child pages that extend the layout can inject their own content-->
       <!-- dus in het yield-"veld" komt alle specifieke inhoud, die verschillend is voor andere pagina's-->
        @yield('content')
    </body>
</html>