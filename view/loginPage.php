<?php
foreach ($errors as $error) {
	echo $error . '<br/>';
}
?>
<section id="apod6" class="apod2">
	<div id="blockLogin">

		<form id="formLogin" method="post">
			<label id="label1" for="newBilletTitle">Login</label>
			<input id="userLogin" type="text" name="userLogin"></br>
			<label id="label2" for="userPassword"> Mot de passe</label>
			<input id="userPassword" type="password" name="userPassword">

			<input type="submit" value="Se connecter">
		</form>
	</div>
</section>