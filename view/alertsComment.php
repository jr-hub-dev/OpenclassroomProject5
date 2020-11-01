<?php if (array_key_exists('userLogin', $_SESSION) && $_SESSION['userLevel'] == 'admin') { ?>
    <section class="apod">
        <div id="blockComments">
            <table>
                <tbody>
                    <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <td><?php echo $comment->getContent(); ?></td>
                            <td>
                                <form method="GET" action="index.php">
                                    <input type="hidden" name="objet" value="comment">
                                    <input type="hidden" name="action" value="noAlert">
                                    <input type="hidden" name="id" value="<?php echo $comment->getId(); ?>">
                                    <input type="submit" value="Valider le commentaire">
                                </form>
                            </td>
                            <td>
                                <form method="GET" action="index.php">
                                    <input type="hidden" name="objet" value="comment">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $comment->getId(); ?>">
                                    <input type="submit" value="supprimer">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
<?php
} else {
    header("Location: index.php?action=home");
    exit();
}
?>