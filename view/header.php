<header>
	<nav id="banniere">

		<ul id="menu">
			<li><a href="index.php?action=home">Accueil</a></li>
			<?php if (empty($_SESSION)) { ?>
				<li><a href='index.php?objet=user&action=create'>S'enregistrer</a></li>
				<a href='index.php?objet=user&action=login'>S'identifier</a>
			<?php } ?>
			<?php if (!empty($_SESSION)) { ?>
				<li><a href="index.php?objet=post&action=postsList">Voir les chapitres</a></li>
				<a href="index.php?objet=user&action=logout">Logout</a>
			<?php } ?>
		</ul>
	</nav>
</header>