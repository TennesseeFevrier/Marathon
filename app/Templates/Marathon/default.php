<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $title .' - ' .Config::get('app.name', SITETITLE); ?></title>
<?php
echo isset($meta) ? $meta : ''; // Place to pass data / plugable hook zone

Assets::css([
    vendor_url('dist/css/bootstrap.min.css', 'twbs/bootstrap'),
    template_url('css/style.css', 'Marathon'),
]);

echo isset($css) ? $css : ''; // Place to pass data / plugable hook zone
?>
</head>
<body>

<header>
    Votre entete est ici!
</header>

<?php
// Le menu login...
if(\Nova\Support\Facades\Auth::check()) {
    echo "Bonjour ". \Nova\Support\Facades\Auth::user()->username." ";
    echo "<a href='".PATH."/logout'>déconnexion</a>";
    ?>
    <a href="<?= PATH.'/histoire' ?>" class="btn btn-primary" role="button">Ajouter une Histoire</a>
    <?php
} else {
    echo "<a href='".PATH."/login'>login</a>&nbsp;<a href='".PATH."/register'>Nouveau ?</a>";
}

 // Le rendu des vues est donné par la variable $content, A GARDER ABSOLUMENT !!!!;?>
    <?= $content; ?>

<footer class="footer">
    Votre pied de page ici
</footer>

<?php
Assets::js([
    vendor_url('dist/js/bootstrap.min.js', 'twbs/bootstrap'),
    template_url('js/jquery-3.1.1.min.js', 'Marathon'),
]);

echo isset($js) ? $js : ''; // Place to pass data / plugable hook zone

echo isset($footer) ? $footer : ''; // Place to pass data / plugable hook zone
?>

<!-- DO NOT DELETE! - Forensics Profiler -->

</body>
</html>
