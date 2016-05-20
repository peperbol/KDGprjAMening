<!DOCTYPE html>
<html lang="en">
    <head>
        <title>A-Mening projecten</title>

        <!-- CSS And JavaScript -->
        
        <!--<link href="css/style.css" rel="stylesheet">-->
        <!-- moet op onderstaande manier zodat de css accessible is in alle views-->
        <link href="{{ asset('css/homepage_style.css') }}" rel="stylesheet" type="text/css" >
    </head>

    <body>
       
       <h1>A-Mening - projecten in Antwerpen</h1>
       
        <div class="left_box">
            
            <div class="map">

            </div>

            <div class="projects_list">
                <!-- hierin komt een lijst met alle projecten -->
                <ul>
                    @foreach($projects as $project)
                        <li>{{ $project->name }}</li>
                    @endforeach
                </ul>
                
            </div>
            
        </div>
        
        <div class="right_box">
            
        </div>
        
        
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!--<script src="{{ asset('js/test.js') }}" type="text/javascript"></script>-->
    

    </body>
</html>




