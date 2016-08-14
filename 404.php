<?php require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/Set404.php');
      require_once locate_template('Functions/SetAll.php');
      require_once locate_template('Functions/MainNav.php');
      require_once locate_template('Functions/Breadcrumb.php'); ?><!DOCTYPE html>
<html <?php echo $siteLang; ?> class="no-js">
  <head>
    <?php require_once locate_template('Functions/Head.php'); ?>
  </head>
  <body itemscope itemtype="https://schema.org/WebPage">
    <nav role="navigation" class="main-nav">
      <div class="wrap">
        <div class="brand-image"><a href="<?php echo $siteUri; ?>"><?php echo $siteName; ?></a></div>
        <input type="checkbox" id="cmd-main-nav">
        <label for="cmd-main-nav"><span></span></label>
        <?php echo $mainNav; ?>
      </div>
    </nav>
    <?php echo $breadcrumb; ?>
    <main itemprop="mainContentOfPage">
      <header role="banner" class="section vh100">
        <div class="wrap-limited ribbon-container">
          <div class="ribbon"><a href="<?php echo $siteUri; ?>"><?php echo $alternativeLink; ?></a></div>
          <h1 itemprop="name" class="emphasized"><?php echo $name; ?></h1>
          <style>
            .meca-anim{display:block;max-width:100%;max-height:50vh;margin:0 auto;fill:#5a728a;stroke:#444;stroke-width:2}
            .meca-anim :nth-child(odd){fill:#b03c57}
            .meca-anim :nth-child(3){fill:#bb7c3c}
            .meca-anim :nth-child(5){fill:#7ca166}
          </style>
          <?php require locate_template('Images/404.svg'); ?><br class="hidden sizeXS-unhidden"><br class="hidden sizeXS-unhidden"><br class="hidden sizeXS-unhidden">
          <?php echo $searchForm; ?>
        </div>
      </header>
    </main>
    <footer id="index-footer" class="section footer center">
      <?php echo $widgetFooter; ?>
      <div class="terms-use">
        <div class="message">
          <p>Bonjour ! En parcourant ce site vous acceptez <a href="<?php echo $siteUri; ?>/legal-notice" style="color:#000">nos conditions générales d'utilisation.</a></p>
          <button id="terms-use" class="button width">oui</button>
        </div>
      </div>
      <div class="old-browers">
        <div class="icon-spaceinvader zoom700"></div><br>
        <p>Old browser!</p><br>
        <p>This site has been developed for modern browsers. In order to benefit from its full functionality, upgrade your browser to date.</p>
      </div>
      <noscript class="noscript">
        <p class="message-warning">Javascript is disabled on your browser, enable it to benefit from all the site's features.</p>
      </noscript>
      <div class="ajax-window-popin"></div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo $templateUri; ?>/Scripts/Vendors/JQuery.js"><\/script>')</script>
    <script>var templateUri = '<?php echo $templateUri; ?>'</script>
    <script src="<?php echo $templateUri; ?>/Public/Scripts/Main.js"></script>
    <?php require locate_template('Functions/GoogleAnalytics.php'); ?>
  </body>
</html>
<?php die(); ?>