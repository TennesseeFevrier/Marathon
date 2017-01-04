<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Script HTML-CSS Repliage image en accordéon : Outils-web.com</title>
    <meta name="description" content="Les images se replient  en accordéon suivant l'axe horizontal pour laisser apparaitre des informations les concernant" />
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style_common.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="js/modernizr.custom.69142.js"></script>
</head>
<div class="page-header">
	<h1><?=$title;?></h1>
</div>

<?php


$nbHistoires = count($histoires);
$i=0;
foreach ($histoiress as $his) {
    //echo "id=". $histoires[$i][0]->id . "= texte =>" . $histoires[$i][0]->texte . "= url =>" . $histoires[$i][0]->url . "<br>";

    if ($i % 2 == 0) {

        ?>
        <section class="histoires">
            <div class="histoires-item histoires-txt">
                <h3 class="title-like"><?= $his->titre ?></h3>
                <p><?= $his->texte ?></p>
                <a class="btn btn-grey" href="<?= PATH . 'histoire'.$his->id ?>" title=" " >Lire l'histoire &raquo;</a>
            </div>
            <div class="histoires-item histoires-img" style="background-image:url(<?= $histoires[$i][0]->url ?>); background-position: top center"></div>
        </section>

    <?php
    }  else { ?>

        <section class="histoires">
            <div class="histoires-item histoires-img" style="background-image:url(<?= $histoires[$i][0]->url ?>); background-position: top center"></div>
            <div class="histoires-item histoires-txt">
                <h3 class="title-like"><?= $his->titre ?></h3>
                <p><?= $his->texte ?></p>
                <a class="btn btn-grey" href="<?= PATH . 'histoire'.$his->id ?>" title=" " >Lire l'histoire &raquo;</a>
            </div>
        </section>

    <?php

    }

    $i++;

} ?>


