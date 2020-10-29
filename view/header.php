<header>
	<nav id="banniere">

		<label for="toggle">&#9776;</label>
		<input type="checkbox" id=toggle>
		<ul id="menu">
			<li><a href="index.php?action=home">Accueil</a></li>
			<li><a href='index.php?objet=user&action=create'>S'enregistrer</a></li>
			<a href='index.php?objet=user&action=login'>S'identifier</a>
			<?php if (array_key_exists('userLogin', $_SESSION)) { ?>
				<a href='index.php?objet=post&action=postsList'>Archives APOD</a>
			<?php } ?>
			<?php if (array_key_exists('userLogin', $_SESSION) && $_SESSION['userLevel'] == 'admin') { ?>
				<a href='index.php?objet=user&action=admin'>Admin</a>
			<?php } ?>
			<?php if (array_key_exists('userLogin', $_SESSION)) { ?>
				<a href="index.php?objet=user&action=logout">Logout</a>
			<?php } ?>
		</ul>
	</nav>
</header>