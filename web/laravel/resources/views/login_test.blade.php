
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Document</title>

</head>

<body>

    <h1>Registreer</h1><br>
				<form role="form" method="POST" action="auth/register">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="text" name="name" placeholder="Gebruikersnaam">
				<input type="text" name="email" placeholder="Email">
				<input type="password" name="password" placeholder="Wachtwoord">
				<input type="password" name="password_confirmation" placeholder="Wachtwoord (nogmaals)">
				<input type="number" name="active" placeholder="active">
				<input type="submit" name="login" class="login loginmodal-submit" value="Registreer">
					<div>@if($errors->has())
							@foreach ($errors->all() as $error)
								<div>{{ $error }}</div>
							@endforeach
						@endif</div>
				</form>
				
				
				<h1>Login met je Account</h1><br>
					<form method="post" action="auth/login">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" name="email" placeholder="Email">
						<input type="password" name="password" placeholder="Wachtwoord">
						<input type="submit" name="login" class="login loginmodal-submit" value="Login">
					</form>


        @if(Auth::check())
            <p>ik ben ingelogd</p>
            
            <h2><a href="auth/logout">Logout</a></h2>
            
            @else
            <p>ik ben NIET ingelogd</p>
            @endif
            
            
            


</body>

</html>



