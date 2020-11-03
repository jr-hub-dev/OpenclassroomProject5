<section id="apod5" class="apod2">
    <?php if (array_key_exists('userLogin', $_SESSION)) { ?>
        <div id="container">
            <h1 class="title2">
                <?php echo $post->getTitle(); ?>
            </h1>

            <img id="picPost" src="<?php echo $post->getUrl(); ?>"><br>
            Image du: <?php echo $post->getCreationDate()->format('d/m/Y'); ?><br>
            <p id="explanation">Description : <?php echo $post->getExplanation(); ?></p>

            <p>Laissez un commentaire</p>

            <form method="post">
                <label for="comment"></label>
                <textarea name="comment" id="comment"></textarea>
                <input type="submit" name="Ajouter" value="Ajouter">
            </form>
            <form method="post">
                <table>
                    <tbody>
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