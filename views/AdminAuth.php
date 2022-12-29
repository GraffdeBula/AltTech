<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>ФОРМА АВТОРИЗАЦИИ</title>
    <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
</head>
<body>
    <div class='g'>
	<div class='g-row'><br></div>
        <div class='g-row'><br></div>
        <div class='g-row'>
        <?php
            
        ?>
        <br></div>
	<div class='f-row'>
            
            <form method='POST' autocomplete="off">
                <input type='hidden' name='usAuth' value='authTrue'>
		<div class='f-input'>
                    <label for='fd_auth'>ЛОГИН</label>
                    <input type='text' name='usLogin' value='' id='usLogin'>
		</div>
				
		<div class='f-input'>
                    <label for='fd_auth'>ПАРОЛЬ</label>
                    <input type='password' name='usPass' value='' id='usPass'>
		</div>
		<div class='f-actions'>
                    <button type='submit' class='f-bu f-bu-warning'>Авторизация</button>
		</div>
            </form>
        </div>
    </div>
</body>
</html>