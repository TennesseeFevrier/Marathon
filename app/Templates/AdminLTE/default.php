<?php
/**
 * Frontend Default Layout
 */

// Generate the Language Changer menu.
$langCode = Language::code();
$langName = Language::name();

$languages = Config::get('languages');

//
ob_start();

foreach ($languages as $code => $info) {
?>
<li class="header <?php if ($code == $langCode) {
    echo 'active';
} ?>" xmlns="http://www.w3.org/1999/html">
    <a href='<?= site_url('language/' .$code); ?>' title='<?= $info['info']; ?>'><?= $info['name']; ?></a>
</li>
<?php
}

$langMenuLinks = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="<?= $langCode; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?> | <?= Config::get('app.name', SITETITLE); ?></title>
    <?= isset($meta) ? $meta : ''; // Place to pass data / plugable hook zone ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
    Assets::css(array(
        // Bootstrap 3.3.5
        vendor_url('bootstrap/css/bootstrap.min.css', 'almasaeed2010/adminlte'),
        // Font Awesome
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        // Ionicons
        'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        // Theme style
        vendor_url('dist/css/AdminLTE.min.css', 'almasaeed2010/adminlte'),
        // AdminLTE Skins
        vendor_url('dist/css/skins/_all-skins.min.css', 'almasaeed2010/adminlte'),
        // iCheck
        vendor_url('plugins/iCheck/square/blue.css', 'almasaeed2010/adminlte'),
        // Custom CSS
        template_url('css/style.css', 'AdminLTE'),
    ));

    echo isset($css) ? $css : ''; // Place to pass data / plugable hook zone

    //Add Controller specific JS files.
    Assets::js(array(
            vendor_url('plugins/jQuery/jquery-2.2.3.min.js', 'almasaeed2010/adminlte'),
        )
    );

    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
  <header id="main-header">
    <img src="../Templates/AdminLTE/Assets/images/Logo.png" id="logo">
    <div class="header-toogle">
        <a href="#main-header" class="header-toogle-open"><img src="../Templates/AdminLTE/Assets/images/menu.png" width="30" alt="Ouvrir Menu"></a>
        <a href="#" class="header-toogle-close"><img src="../Templates/AdminLTE/Assets/images/menu-close.png" width="30" alt="Fermer Menu"></a>
    </div>
    <nav class="header-menu">
      <div>
          <a href="<?= PATH; ?>" title="Accueil">Accueil</a>
          <?php if (Auth::check()) { ?>
          <a href="<?= PATH; ?>histoire" title="Ajouter une histoire"">Ajouter une histoire</a>
          <a href='<?= site_url('logout'); ?>'><?= __d('adminlte', 'Déconnexion'); ?></a>
          <?php } else { ?>
          <a href='<?= site_url('register'); ?>'><?= __d('adminlte', 'S\'inscrire'); ?></a>
          <a href='<?= site_url('login'); ?>'><?= __d('adminlte', 'Se connecter'); ?></a>
          <?php } ?>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
    <!-- Content Wrapper. Contains page content -->
    <div class="container">
        <!-- Main content -->
        <section class="content">
            <?= $content; ?>
        </section>
    </div>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <?php if(Config::get('app.debug')) { ?>
      <small><!-- DO NOT DELETE! - Profiler --></small>
      <?php } ?>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="http://www.novaframework.com/"><b>Nova Framework <?= VERSION; ?></b></a> - </strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?php
Assets::js(array(
    // Bootstrap 3.3.5
    vendor_url('bootstrap/js/bootstrap.min.js', 'almasaeed2010/adminlte'),
    // AdminLTE App
    vendor_url('dist/js/app.min.js', 'almasaeed2010/adminlte'),
    // iCheck
    vendor_url('plugins/iCheck/icheck.min.js', 'almasaeed2010/adminlte'),
));

echo isset($js) ? $js : ''; // Place to pass data / plugable hook zone

echo isset($footer) ? $footer : ''; // Place to pass data / plugable hook zone
?>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<!-- DO NOT DELETE! - Forensics Profiler -->

</body>
</html>
