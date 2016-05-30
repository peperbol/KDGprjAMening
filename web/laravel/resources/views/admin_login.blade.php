<!DOCTYPE html>

<html lang="nl">

<head>

    <meta charset="UTF-8">
    <link href="{{ asset('css/style_admin_login.css') }}" rel="stylesheet" type="text/css">
    <title>Admin login</title>

</head>

<body>

   
    <h1>Registreer</h1>
				<form role="form" method="POST" action="auth/register">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="text" name="name" placeholder="Gebruikersnaam">
				<input type="text" name="email" placeholder="Email">
				<input type="password" name="password" placeholder="Wachtwoord">
				<input type="password" name="password_confirmation" placeholder="Wachtwoord (nogmaals)">
				<input type="number" name="active" placeholder="active" value="1" readonly>
				<input type="submit" name="login" class="login loginmodal-submit" value="Registreer">
					<div>@if($errors->has())
							@foreach ($errors->all() as $error)
								<div>{{ $error }}</div>
							@endforeach
						@endif</div>
				</form>
				
				
               <div class="login_form">
                    <h2 class="login_title">A Mening</h2>
	                <h4 class="login_subtitle">Adminplatform</h4>
	            
					<form method="post" action="auth/login">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
						<div class="email">
                            <label for="email">Email:</label>
						    <input id="email" type="email" name="email" placeholder="Email">
						</div>
						
						<div class="password">
                            <label for="pasword">Wachtwoord:</label>
						    <input id="password" type="password" name="password" placeholder="Wachtwoord">
						</div>
						
						
						<input type="submit" name="login" class="login loginmodal-submit" value="Login">
						<div>
						@if($errors->has())
							@foreach ($errors->all() as $error)
								<div>{{ $error }}</div>
							@endforeach
						@endif
						</div>
					</form>
               </div>
                
				    

        
        
        
    {{--
            @if(Auth::check())
            <p>ik ben ingelogd</p>
            
            <h2><a href="auth/logout">Logout</a></h2>
            
            @else
            <p>ik ben NIET ingelogd</p>
            @endif
          --}}  
            
            


</body>

</html>