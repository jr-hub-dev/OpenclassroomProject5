<section id="landscape">
    <table>
        <tbody>
            <?php foreach ($posts as $post) { ?>
                <tr>
                    <td><a href="index.php?objet=post&action=view&id=<?php echo $post->getId(); ?>" title="afficher <?php echo $post->getTitle(); ?> - <?php echo $post->getId(); ?>"><?php echo $post->getTitle(); ?></a></td><br />
                    <td><img src = <?php echo $post->getUrl(); ?>></td>
                    <td><?php echo $post->getExplanation(); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</section>