<?php
//сохранение инф в сессию
if ((isset($_POST['form1'])) and ($_POST['form1']=='active')){
	$sessName=$_POST['sessionname'];
	$sessInf=$_POST['info'];
	session_name($sessName);
	session_start();
	$_SESSION['info']=$sessInf;
}
//показ инф из сессии: показать куку, если она есть, и всё что хранится в связанной сессии
if ((isset($_POST['form2'])) and ($_POST['form2']=='active')){
	$sessName=$_POST['sessionname'];
	session_name($sessName);
	session_start();
	$sessInf=$_SESSION['info'];
}
//удаление куки
if ((isset($_POST['form3'])) and ($_POST['form3']=='active')){
	$sessName=$_POST['sessionname'];
	setcookie($sessName,'',time()-1,'/');
	header("Location: index_admin.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>session</title>
</head>
<body>
	<form method="POST">
		<h6>СОЗДАНИЕ СЕССИИ</h6>
		<input type="hidden" name="form1" value="active">
		<label>имя сессии</label><input type="text" name="sessionname" value="" autocomplete="off"><br>
		<label>информация</label><input type="text" name="info" value="" autocomplete="off"><br>
		<button type="submit">CREATE</button>
	</form>
	<br>
	<div>
		<?php
			foreach ($_COOKIE as $name => $value) {
				echo("<p>{$name} --> {$value}</p>");
			}
		?>
	</div>
	<br>
	<form method="POST">
		<h6>УДАЛЕНИЕ КУКИ</h6>
		<input type="hidden" name="form3" value="active">
		<label>имя сессии</label><input type="text" name="sessionname" value="" autocomplete="off"><br>		
		<button type="submit">DELETE</button>
	</form>
	<br><br>
	<form method="POST">
		<h6>ПОКАЗАТЬ ИНФОРМАЦИЮ</h6>
		<input type="hidden" name="form2" value="active">
		<label>имя сессии</label><input type="text" name="sessionname" value="" autocomplete="off"><br>		
		<button type="submit">SHOW</button>
	</form>
	<div>
		<?php
			echo("<p>{$sessInf}</p>");
		?>
	</div>
</body>
</html>