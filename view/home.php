<?php
require_once('header.php');
?>

<body>
    <section id="welcome">
        <video src="./video/smoke.mp4" autoplay muted></video>
        <h1 id="mainTitle">
            <span>E</span>
            <span>x</span>
            <span>o</span>
            <span>W</span>
            <span>e</span>
            <span>b</span>
        </h1>

        <a id="scroll" href="#title2"><span></span><i class="fas fa-chevron-down fa-4x"></i></a>
    </section>
    <section class="apod">
        <h2 id="title2">NASA Astronomy Picture Of The Day</h2>
        <h3 id="title"></h3>
        <h4>Date: <span id="date"></span></h4>
        <img id="pic" src="" alt="NASA Picture Of The Day" width="100%">
        <p id="explanation"></p>
    </section>
</body>
<script src="js/script.js"></script>
<?php
require_once('footer.php');
?>