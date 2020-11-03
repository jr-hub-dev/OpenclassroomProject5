<section id="apod3" class="apod2">
    <?php if (array_key_exists('userLogin', $_SESSION) && $_SESSION['userLevel'] == 'admin') { ?>
        <div id ="blockAdmin">
            <a id="button1" class="button" href="index.php?objet=user&action=alertsUser">Voir les nouveaux utilisateurs</a><br>
            <a id="button2" class="button" href="index.php?objet=comment&action=alertsComment">Voir les commentaires signalés</a>
        </div>
    <?php
    } else {
        header("Location: index.php?action=home");
        exit();
    }
    ?>
</section>