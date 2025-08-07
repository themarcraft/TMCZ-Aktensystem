<?php

use de\themarcraft\ggh\Mitarbeiter;

include($_SERVER['DOCUMENT_ROOT'] . '/website/_inc.php');
?>
<body>
<header data-bs-theme="dark">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Berliner Zentralklinikum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Unser Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#bewerben">Bewerben</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feedback">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#erste-hilfe">Erste-Hilfe-Kurse</a>
                    </li>
                </ul>
                <ul class="navbar-nav me-2 mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/?s=login">Intranet</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>

    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div style="height:100%; background-image:url('/website/images/kh1.png'); background-size:cover; background-position:center center; background-repeat:no-repeat;">
                </div>
                <!--<img src="/website/images/kh1.png" height="100%">-->
                <div class="container">
                    <div class="carousel-caption text-start bg-secondary rounded p-5">
                        <h1>Das Berliner Zentralklinikum.</h1>
                        <p class="opacity-75">Seit 2025 retten wir Leben.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div style="height:100%; background-image:url('/website/images/intensiv.png'); background-size:cover; background-position:center center; background-repeat:no-repeat;">
                </div>
                <!--<img src="/website/images/intensiv.png" height="100%">-->
                <div class="container">
                    <div class="carousel-caption bg-secondary rounded p-5">
                        <h1>Unser Team.</h1>
                        <p>Wir sind <?php $i = 0;
                            foreach (Mitarbeiter::getMitarbeiter() as $mitarbeiter) {
                                if ($mitarbeiter->getRangId() <= 5) {
                                    $i++;
                                }
                            }
                            echo $i; ?> kompetente Ärzte und <?php $i = 0;
                            foreach (Mitarbeiter::getMitarbeiter() as $mitarbeiter) {
                                if ($mitarbeiter->getRangId() >= 8 and $mitarbeiter->getRangId() <= 10) {
                                    $i++;
                                }
                            }
                            echo $i; ?> Azubis.</p>
                        <p><a class="btn btn-lg btn-primary" href="#team">Unser Team</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div style="height:100%; background-image:url('/website/images/op.png'); background-size:cover; background-position:center center; background-repeat:no-repeat;">
                </div>
                <!--<img src="/website/images/op.png" style="height:100%; object-fit:cover; object-position:center;">-->
                <div class="container">
                    <div class="carousel-caption text-end bg-secondary rounded p-5">
                        <h1>Werde teil des Teams.</h1>
                        <p>Bewirb dich jetzt bei uns.</p>
                        <p><a class="btn btn-lg btn-primary" href="https://forms.office.com/r/4cgBWM5n9h"
                              target="_blank">Bewerben</a></p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- Unsere Mitarbeiter -->
    <!-- ================================================== -->

    <hr class="featurette-divider" id="team">

    <div class="container">
        <div class="container w-100 mb-3" style="text-align: center">
            <h2>Unser Team</h2>
        </div>
        <div class="row">
            <?php
            foreach (Mitarbeiter::getMitarbeiter() as $mitarbeiter) {
                if ($mitarbeiter->getRangId() != 99) {
                    ?>
                    <div class="col-lg-4">
                        <?php if ($mitarbeiter->getPb() == "") {
                            echo '<svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-color)"/></svg>';
                        } else { ?>
                            <img src="/website/images/<?= $mitarbeiter->getPb() ?>" class="rounded-circle" width="140"
                                 height="140">
                        <?php } ?>
                        <h2 class="fw-normal"><?php if ($mitarbeiter->getRangId() <= 5) {
                                echo "Dr. med. ";
                            } ?><?= $mitarbeiter->getVorname() . " " . $mitarbeiter->getNachname() ?></h2>
                        <p><?= $mitarbeiter->getRang() ?><?php if ($mitarbeiter->getAnmerkung() != '') {
                                if ($mitarbeiter->getRangId() <= 3) {
                                    echo " und Facharzt für ";
                                }
                                echo $mitarbeiter->getAnmerkung();
                            } ?></p>
                    </div>
                <?php }
            }
            ?>


            <!--  -->

            <hr class="featurette-divider" id="bewerben">

            <div class="row featurette mb-5">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading fw-normal lh-1">Unsere Jobs</h2>
                    <p class="lead">Wir suchen aktuell Pfleger und Assistenzärzte, die wir auch ausbilden.</p>
                    <h4 class="mb-0">Dein Job als Assistenzarzt</h4>
                    <li class="lead">Begleite unsere Ärzte bei ihrem Arbeitstag und Assistiere ihnen</li>
                    <li class="lead">Werde selbst als Arzt bei uns Ausgebildet</li>
                    <li class="lead">Betreue und Behandle unsere Patienten</li>
                    <li class="lead">Fahre auch mal mit unseren Ärzten auf Notarzt Fahrten</li>
                    <!-- -->
                    <h4 class="mb-0 mt-3">Dein Job als Pfleger</h4>
                    <li class="lead">Betreue unsere Patienten und überwache diese</li>
                    <li class="lead">Helfe bei der Wundversorgung etc.</li>
                    <li class="lead">Dokumentiere den gesamten Prozess in unseren Akten</li>
                    <li class="lead">Unterstütze unsere Ärzte</li>
                </div>
                <div class="col-md-5 order-md-1">
                    <img class="featurette-image img-fluid mx-auto mb-3" src="/website/images/intensiv.png">
                    <img class="featurette-image img-fluid mx-auto mb-3" src="/website/images/op.png">
                </div>
            </div>

            <!-- -->

            <div class="row featurette mb-5">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">Bewirb dich jetzt!</h2>
                    <p class="lead">Und genieße unsere Perks</p>
                    <h4 class="mb-0">Deine Vorteile</h4>
                    <li class="lead">Attraktives Gehalt</li>
                    <li class="lead">Nette Kollegen</li>
                    <li class="lead">Freie Urlaubswahl</li>
                    <li class="lead">After Work Parties mit Pizza und Cola</li>
                    <li class="lead">Kooperation mit der Anwaltskanzlei</li>
                    <li class="lead">Betriebliche Krankenversicherung</li>
                    <li class="lead">Gute Aufstiegsmöglichkeiten</li>
                    <!-- -->
                    <h4 class="mt-3 mb-0">Das erwarten wir von Dir</h4>
                    <li class="lead">Medizinische Vorkenntnisse</li>
                    <li class="lead">Vorbildliches Verhalten gegenüber Vorgesetzten und Kollegen</li>
                    <li class="lead">Lernfähigkeit</li>
                    <li class="lead">Motivation</li>
                    <a href="https://forms.office.com/r/4cgBWM5n9h" target="_blank" class="btn btn-primary m-3">Bewerbungsformular</a>
                </div>
                <div class="col-md-5">
                    <img class="featurette-image img-fluid mx-auto mb-3 w-100" src="/website/images/maltemeier.png">
                </div>
            </div>

            <hr class="featurette-divider" id="feedback">

            <div class="row featurette mt-5 mb-5">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading fw-normal lh-1">Kritik oder Feedback zu Behandlungen?</h2>
                    <p class="lead">Wenn es bei deiner Behandlung Probleme mit den Ärzten oder Probleme im Krankenhaus gab oder du uns einfach nur Feedback geben möchtest, dann kannst du uns über dieses Formular Feedback geben. Wenn du fragen hast kannst du gerne auf unseren Discord Server um uns zu kontaktieren.</p>
                    <a href="https://discord.gg/7UCW7pGP8x" target="_blank" class="btn btn-primary m-3">Discord Server</a>
                    <a href="https://forms.office.com/r/M8mi6yR3Bx" target="_blank" class="btn btn-secondary m-3">Feedback Formular</a>
                </div>
                <div class="col-md-5 order-md-1">
                    <i style="font-size: 400px" class="fa-solid fa-comments featurette-image img-fluid mx-auto mb-3"></i>
                </div>
            </div>

            <hr class="featurette-divider" id="erste-hilfe">

            <div class="row featurette mt-5 mb-5">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">Erste-Hilfe-Kurse</h2>
                    <p class="lead">Du möchtest eine Erste-Hilfe-Ausbildung bei uns absolvieren? Bei uns kriegst du nach einer Teilnahme von 2 UE (=20 Minuten) einen Erste-Hilfe-Schein den du verwenden kannst um z.B. dich für bestimmte Berufe zu bewerben. Wenn du teilnehmen möchtest, fülle bitte das Formular unten aus. Erste-Hilfe-Kurse werden von Dr. med. Malte Meier und Dr. med. Julian Wolf an Wochenenden durchgeführt, wenn mindestens 2 Menschen sich für den Kurs angemeldet haben.</p>
                    <a href="https://forms.office.com/r/HduPqF1Z4Y" target="_blank" class="btn btn-primary m-3">Anmeldungsformular</a>
                </div>
                <div class="col-md-5">
                    <i style="font-size: 500px" class="fa-solid fa-suitcase-medical featurette-image img-fluid mx-auto mb-3"></i>
                </div>
            </div>

            <hr class="featurette-divider">

            <!--  -->

        </div><!-- /.container -->


        <!-- FOOTER -->
        <footer class="container">
            <p>&copy; 2025 Berliner Zentralklinikum. &middot; <b>Es handelt sich hierbei um ein fiktives Krankenhaus von dem FiveM RP
                    Server <a href="https://discord.gg/6ncFSp9fEP">SpandauRP</a></b></p>
        </footer>
</main>
</body>
</html>