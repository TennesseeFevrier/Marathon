<?php
$nbAimes= 0;
foreach ($aimes as $a){
    $nbAimes++;
}
?>

    <h1 class="titre-histoire"><?= $histoires[$id]->titre ?>
        <a
            <?php if (Auth::check() && $aimeDeja == false) { ?>
            href="<?= PATH . 'aime'.$idHistoire ?>"
            <?php } else if (Auth::check() && $aimeDeja == true) { ?>
            href="<?= PATH . 'supprimerAime'.$idHistoire ?>"
            <?php } else { ?>
            href="<?= PATH . 'register' ?>"
            <?php } ?>
        >
            <?php if ($aimeDeja == false) { ?>
            <img class="coeur" src="../Templates/AdminLTE/Assets/images/coeur_vide.png">
            <?php } else { ?>
            <img class="coeur" src="../Templates/AdminLTE/Assets/images/coeur_plein.png">
            <?php } ?>
        </a>
        <p class="nbAime"><?= $nbAimes ?></p>
    </h1>

<p class="texte"><?= $histoires[$id]->texte ?></p>

<?php
foreach ($images as $i) {

?>

<section class="histoires">
    <div class="histoires-item">
        <img class="image-histoire" src="<?= $i->url ?>">
    </div>
    <div class="histoires-item histoires-txt">
        <h3 class="title-like"><?= $i->titre ?></h3>
        <p><?= $i->texte ?></p>
    </div>
</section>

<?php } ?>




<div>
    <?php
    if(Auth::check()) {?>

        <h3>Ajouter un commentaire</h3>

        <form method="post" action="<?=PATH;?>ajoutCommentaire<?=$idHistoire;?>">

        <textarea style="width: 100%;" type="texte" name='texte' id="texte" value=""></textarea>
            <button class="btn btn-grey" type="submit">Valider</button>
        </form>
        <br />
        <br />
        <br />


        <?php
    }
?>
    <br />
    <br />
    <h3>Commentaires</h3>
    <br />
    <br />
    <?php
    foreach($histoires[$id]->commentaires as $c){
        ?>
    <section class="commentaire histoires">
    <div>
        <p class="Liste-commentaire"><?= $c->texte ?></p>
    </div>
        <br />
        <div>
            <p> par <?= $c->auteur->username ?></p>
        </div>
    </section>
        <br />
    <?php
    }
        //echo $c->texte." " . $c->auteur->username;
    ?>
</div>