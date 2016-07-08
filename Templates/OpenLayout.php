<?php // Template Name: Open Layout
      require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/SetSingle.php');
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
      <article itemscope itemtype="https://schema.org/Article" class="article"><?php echo $image; ?>
        <div id="index-article">
          <div class="wrap">
            <?php echo $content; ?>
            <aside class="button-group">
              <div>
                <button title="Print article" class="button cmd-print"><span class="icon-printer"></span></button>
              </div>
              <?php if (( $capacityRead AND $commentsOpen AND is_single() )): ?>
              <div>
                <button title="Comment article" id="comments" class="button"><span class="icon-bubbles"></span></button>
              </div>
              <?php endif;
                    if ($capacityEditPosts): ?>
              <form action="<?php echo $editPost; ?>" method="post" target="_blank">
                <button title="Edit article" class="button"><span class="icon-pen"></span></button>
              </form>
              <?php endif; ?>
            </aside>
          </div>
        </div>
      </article>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo $templateUri; ?>/Scripts/Vendors/JQuery.js"><\/script>')</script>
    <script>var templateUri = '<?php echo $templateUri; ?>'</script>
    <script src="<?php echo $templateUri; ?>/Public/Scripts/Main.js"></script>
    <?php require locate_template('Functions/GoogleAnalytics.php'); ?>
  </body>
</html>
<?php die(); ?>