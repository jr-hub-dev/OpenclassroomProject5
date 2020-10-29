<?php if (array_key_exists('userLogin', $_SESSION) && $_SESSION['userLevel'] == 'admin') { ?>
    <a class="button" href="index.php?objet=user&action=alertsUser">Voir les nouveaux utilisateurs</a>
    <a class="button" href="index.php?objet=comment&action=alertsComment">Voir les commentaires signalés</a>
<?php
} else {
    header("Location: index.php?action=home");
    exit();
}
?>