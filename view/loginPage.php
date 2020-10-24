<?php
foreach ($errors as $error) {
	echo $error . '<br/>';
}
?>
<section id="landscape">

	<form class="formLogin" method="post"><?php if (empty($_SESSION['userLogin'])) {
												echo '
		<label for="newBilletTitle">Login</label>
		<input id="userLogin" type="text" name="userLogin" >
		<label for="userPassword"> Mot de passe :</label>
		<input id="userPassword" type="password" name="userPassword">

		<input type="submit" value="Se connecter">';
											} else {
												echo 'Vous êtes déjà logué';
											} ?></form>
</section>