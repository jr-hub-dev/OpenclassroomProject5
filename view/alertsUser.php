<section id="landscape">
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user->getId(); ?></td>
                        <td><?php echo $user->getLogin(); ?></td>
                        <td>
                            <form method="GET" action="index.php">
                                <input type="hidden" name="objet" value="user">
                                <input type="hidden" name="action" value="accept">
                                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>" >
                                <input type="submit" value="Valider l'utilisateur">
                            </form>
                        </td>
                        <td>
                            <form method="GET" action="index.php">
                                <input type="hidden" name="objet" value="user">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $user->getId(); ?>" >
                                <input type="submit" value="supprimer l'utilisateur">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>