<header>
	<nav id="banniere">

		<label for="toggle">&#9776;</label>
		<input type="checkbox" id=toggle>
		<ul id="menu">

			<li><a href="index.php?action=home">Accueil</a></li>

			<?php if (!array_key_exists('userLogin', $_SESSION)) { ?>
				<li><a href='index.php?objet=user&action=create'>S'enregistrer</a></li>
				<li><a href='index.php?objet=user&action=login'>S'identifier</a></li>
			<?php } ?>
			<?php if (array_key_exists('userLogin', $_SESSION) && $_SESSION['userLevel'] == 'admin') { ?>
				<li><a href='index.php?objet=user&action=admin'>Admin</a></li>
			<?php } ?>
			<?php if (array_key_exists('userLogin', $_SESSION)) { ?>
				<li><a href='index.php?objet=post&action=postsList'>Archives</a></li>
				<li><a href='index.php?objet=user&action=upload'>Envoyer vos photos!</a></li>
				<li><a href="index.php?objet=user&action=logout">Logout</a></li>
			<?php } ?>
		</ul>
	</nav>
</header>