<?php
include "link_checker.php";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo urlCheck("../LordsAssistant/")?>">Lords Assistant</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-sm-0 nav-items">
                <li class="nav-item main-nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo urlCheck("../LordsAssistant/")?>">Home</a>
                </li>

                <li class="nav-item dropdown main-nav-item">
                    <a class="nav-link dropdown-toggle active" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tools
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo urlCheck("gf")?>">
                            <li>Gf Points</li>
                        </a>
                        <a class="dropdown-item" href="<?php echo urlCheck("kvk")?>">
                            <li>Kvk Points</li>
                        </a>
                        <!-- <li><hr class="dropdown-divider"></li> -->
                        <a class="dropdown-item" href="<?php echo urlCheck("timezone")?>">
                            <?php echo "<li>Timezone</li>" ?>
                        </a>
                    </ul>
                </li>

                <li class="nav-item main-nav-item">
                    <a class="nav-link active" href="<?php echo urlCheck("contact")?>">Contact</a>
                </li>


                <li class="nav-item main-nav-item">
                    <a class="nav-link active" href="<?php echo urlCheck("about")?>">About</a>
                </li>


            </ul>

        </div>
    </div>
</nav>