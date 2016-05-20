<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>

        <!-- CSS And JavaScript -->
        
        <!--<link href="css/style.css" rel="stylesheet">-->
        <!-- moet op onderstaande manier zodat de css accessible is in alle views-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
        @yield('pageSpecificCSS')
    </head>

    <body>
        <div class="container">
            <nav class="navbar">
                <!-- Navbar Contents -->
                <ul>
                    <li><a href="{{ url('/overview') }}">Project overzicht</a></li>
                    <li><a href="{{ url('/add_project') }}">Project toevoegen</a></li>
                    <li><a href="{{ url('/comments') }}">Reacties</a></li>
                </ul>
            </nav>
        </div>

       <!--special Blade directive that specifies where all child pages that extend the layout can inject their own content-->
       <!-- dus in het yield-"veld" komt alle specifieke inhoud, die verschillend is voor andere pagina's-->
       <div>
        @yield('content')
        </div>
        
        <footer>
            <div>
                &copy; 2016 A-Mening (designed by Petrichor)
            </div>
        </footer>
        
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <!-- adhv van de section hieronder kan je dan pagina-specifieke javscriptfiles inladen -->
        @yield('pageSpecificJavascript')
        
    </body>
</html>