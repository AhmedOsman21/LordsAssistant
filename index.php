<?php $style="style"?>

<?php include "header.php"?>

<body>

    <!-- Header -->
    <?php include "nav.php" ?>

    <!-- Home Sections -->
    <div class="container home-section">
        <h2 class="h1 mb-4 section-heading">Tools</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="card home-card">
                    <div class="card-body">
                        <h4 class="card-title">Calculate GF Points</h4>
                        <p class="card-text">Know how many points on each remain task you have to make to achieve the required points.</p>
                        <a href="gf.php" class="btn btn-success">Guild Fest Calculator</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card home-card">
                    <div class="card-body home-card">
                        <h4 class="card-title">Calculate KVK Points</h4>
                        <p class="card-text">Know how much resources you have gather in order to complete the KVK Points.</p>
                        <a href="kvk.php" class="btn btn-success">KVK Calculator</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <!-- FAQ -->
    <div class="container mt-5 home-section">

        <h2 class="h1 mb-4 section-heading">FAQ</h2>
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        <strong>What is Lords Mobile?</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body faq-info">
                        Lords Mobile is a video strategy game. The game is free to play and offers in-app purchases. According to App Annie, the game is one of the top-grossing apps on the App Store and Google Play.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <strong>What's the purpose of this app?</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body faq-info">
                    This application meant to help me and other busy/lazy lords mobile gamers to know the minimum amount of work they can do to accomplish points for a particular event.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        <strong>What is the "Timezone" option?</strong>
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                    <div class="accordion-body faq-info">
                      With  the <a href="timezone.php">Timezone</a> tool which is in the tools dropmenu, you can know your friends time right now in your local timezone, so that you can know what's the time in your guild's country.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
		<?php include "footer.php"?>
</body>

</html>