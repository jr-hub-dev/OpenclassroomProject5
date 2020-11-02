<?php if (array_key_exists('userLogin', $_SESSION)) { ?>
    <section class="apod">

        <h1>Proposer vos photos du ciel, elles seront peut-être selectionnées pour apparaître sur notre site prochainement !</h1>
        <div class="block">
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="uploaded_file" /> <br />
                <input type="submit" name="submit" /> <br />

            </form>
        </div>
    </section>
<?php
} else {
    header("Location: index.php?action=home");
    exit();
}
?>