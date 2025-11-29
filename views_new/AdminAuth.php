<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>ФОРМА АВТОРИЗАЦИИ</title>    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/_bootswatch.scss">
    <link rel="stylesheet" type="text/css" href="css/_variables.scss">
</head>
<body>
    <div>
	<div class='row'><br></div>
        <div class='row'><br></div>
        
	<div class='row'>
            
            <form method='POST' autocomplete="off">
                <input type='hidden' name='usAuth' value='authTrue'>
                    <p>
                        <label for='usLogin'>ЛОГИН</label>
                        <input type='text' name='usLogin' value='' id='usLogin' required="">
                    </p>
				
                    <p>
                        <label for='usPass'>ПАРОЛЬ</label>
                        <input type='password' name='usPass' value='' id='usPass' required="">
                    </p>
		
                    <button class='btn btn-danger'>Авторизация</button>
		
            </form>
        </div>
    </div>
</body>
</html>