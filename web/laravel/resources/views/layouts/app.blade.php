<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Laravel Quickstart - Basic</title>

        <!-- CSS And JavaScript -->
        
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-default">
                <!-- Navbar Contents -->
                <ul>
                    <li><a href="{{ url('/overview') }}">Project overzicht</a></li>
                    <li><a href="{{ url('/add') }}">Project toevoegen</a></li>
                    <li><a href="{{ url('/comments') }}">Reacties</a></li>
                </ul>
            </nav>
        </div>

       <!--special Blade directive that specifies where all child pages that extend the layout can inject their own content-->
       <!-- dus in het yield-"veld" komt alle specifieke inhoud, die verschillend is voor andere pagina's-->
        @yield('content')
    </body>
</html>