
<?php require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/Set404.php');
      require_once locate_template('Functions/SetAll.php');
      require_once locate_template('Functions/MainNav.php');
      require_once locate_template('Functions/Breadcrumb.php'); ?><!DOCTYPE html>
<html class="no-js" <?php echo $siteLang; ?>>
  <head>
    <?php require_once locate_template('Functions/Head.php'); ?>
  </head>
  <body <?php echo $bodyMetas; ?>>
    <nav class="main-nav" role="navigation">
      <div class="wrap">
        <div class="brand-image onaline"><a href="<?php echo $siteUri; ?>"><?php echo $siteName; ?></a></div>
        <input type="checkbox" id="cmd-main-nav">
        <label for="cmd-main-nav"><span></span></label>
        <?php echo $mainNav; ?>
      </div>
    </nav>
    <?php echo $breadcrumb; ?>
    <main itemprop="mainContentOfPage">
      <header class="section" role="banner">
        <div class="wrap-limited ribbon-container">
          <div class="ribbon"><a href="<?php echo $siteUri; ?>"><?php echo $alternativeLink; ?></a></div>
          <h1 class="emphasized" itemprop="name"><?php echo $name; ?></h1>
          <div class="grid">
            <div class="m2 sizeS-m4 vertical"><span class="icon-arrow-up surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical"><span class="icon-arrow-left surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical"><span class="icon-arrow-down surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical"><span class="icon-arrow-right surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeS-hidden"><span class="icon-arrow-up surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeS-hidden"><span class="icon-arrow-left surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeS-hidden"><span class="icon-arrow-down surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeXS-hidden"><span class="icon-arrow-right surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeXS-hidden"><span class="icon-arrow-up surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeXS-hidden"><span class="icon-arrow-left surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeXS-hidden"><span class="icon-arrow-down surround zoom500"></span></div>
            <div class="m2 sizeS-m4 vertical sizeXS-hidden"><span class="icon-arrow-right surround zoom500"></span></div>
          </div><br>
          <?php echo $searchForm; ?>
        </div>
      </header>
    </main>
    <footer class="section footer center" id="index-footer">
      <?php echo $widgetFooter; ?>
      <div id="terms-use">
        <div class="message">
          <p>Bonjour ! En parcourant ce site vous acceptez <a href="<?php echo $siteUri; ?>/legal-notice" style="color:#000;">nos conditions générales d'utilisation.</a></p>
          <button class="button width">oui</button>
        </div>
      </div>
      <div class="old-browers">
        <div class="icon-spaceinvader zoom700"></div><br>
        <p>Old browser!</p><br>
        <p>The site can not be displayed with this browser. Update your browser.</p>
      </div>
      <noscript class="noscript">
        <p class="message-warning">Javascript is disabled on your browser, enable it to benefit from all the site's features.</p>
      </noscript>
      <div class="ajax-window-popin"></div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo $templateUri; ?>/Scripts/Vendors/JQuery.js"><\/script>')</script>
    <script>var templateUri = '<?php echo $templateUri; ?>'</script>
    <script src="<?php echo $templateUri; ?>/Public/Scripts/Main.js<?php echo $version; ?>"></script>
    <?php require locate_template('Functions/GoogleAnalytics.php'); ?>
  </body>
</html>
<?php exit; ?>