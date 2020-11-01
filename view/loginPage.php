<?php
foreach ($errors as $error) {
	echo $error . '<br/>';
}
?>
<section class="apod">
	<div class="block">

		<form class="formLogin" method="post">
			<label for="newBilletTitle">Login</label>
			<input id="userLogin" type="text" name="userLogin">
			<label for="userPassword"> Mot de passe :</label>
			<input id="userPassword" type="password" name="userPassword">

			<input type="submit" value="Se connecter">
		</form>
	</div>
</section>