<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>

        <!-- CSS And JavaScript -->
        
        <!--<link href="css/style.css" rel="stylesheet">-->
        <!-- moet op onderstaande manier zodat de css accessible is in alle views-->
        <!--<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >-->
        <link href="{{ asset('css/style_admin.css') }}" rel="stylesheet" type="text/css">
        <!-- custom icon font -->
        <link href="https://file.myfontastic.com/DGQi5KcuH4nnZiJNVERR6H/icons.css" rel="stylesheet">
        @yield('pageSpecificCSS')
    </head>

    <body>
        <header>
            <div class="headerContent">
                <nav class="navbar">
                    <!-- Navbar Contents -->
                    <ul>
                        <li><a href="{{ url('/overview') }}" class="{{ (Route::getCurrentRoute()->getPath() == 'overview') ? 'active' : '' }}">Project overzicht</a></li>
                        <li><a href="{{ url('/add_project') }}" class="{{ (Route::getCurrentRoute()->getPath() == 'add_project') ? 'active' : '' }}">Project toevoegen</a></li>
                        <li><a href="{{ url('/comments') }}" class="{{ (Route::getCurrentRoute()->getPath() == 'comments') ? 'active' : '' }}">Reacties</a></li>
                        
                        <li class="usernameLi">
                        <a href="#">Username</a>
                        <ul>
                            <li><a href="account.html">Account Wijzigen</a></li>
                            <li><a href="adminToevoegen.html">Admin Toevoegen</a></li>
                            <li><a href="uitloggen.html">Uitloggen</a></li>
                        </ul>
                    </li>
                    </ul>
                </nav>
            </div>
        </header>
        
        
       
       

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