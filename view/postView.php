<section class="apod">
    <?php if (array_key_exists('userLogin', $_SESSION)) { ?>
        <div id="container">
            <h1>
                <?php echo $post->getTitle(); ?>
            </h1>

            <img src="<?php echo $post->getUrl(); ?>"><br>
            Image du: <?php echo $post->getCreationDate()->format('d/m/Y'); ?><br>
            Description : <?php echo $post->getExplanation(); ?>

            <form method="post">
                <label for="comment">Commentaire</label>
                <textarea name="comment" id="comment"></textarea>
                <input type="submit" name="Ajouter" value="Ajouter">
            </form>
            <form method="post">
                <table>
                    <tbody>
                        Des gens ont laissé un commantaire
                        <?php foreach ($comments as $comment) { ?>
                            <tr>
                                <td><?php echo $comment->getContent(); ?></td>
                                <td><a href="index.php?objet=comment&action=alert&id=<?php echo $comment->getId(); ?>">Signaler</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    <?php
    } else {
        header("Location: index.php?action=home");
        exit();
    }
    ?>
</section>