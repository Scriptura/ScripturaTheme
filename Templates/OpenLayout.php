
<?php // Template Name: Open Layout
      require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/SetSingle.php');
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
      <article class="article" itemscope itemtype="https://schema.org/Article"><?php echo $image; ?>
        <div id="index-article">
          <div class="wrap">
            <?php echo $content; ?>
            <aside class="button-group">
              <div>
                <button class="button cmd-print" title="Print article"><span class="icon-printer"></span></button>
              </div>
              <?php if ($capacityRead AND $commentsOpen AND is_single()): ?>
              <div>
                <button class="button" title="Comment article" id="comments"><span class="icon-bubbles"></span>
                  <?php if (is_single() AND get_comments_number()):
                        echo get_comments_number();
                        endif; ?>
                </button>
              </div>
              <?php endif;
                    if (( $capacityEditPosts AND is_single() ) OR ( $capacityEditPages AND !is_single() )): ?>
              <form action="<?php echo $editPost; ?>" method="post">
                <button class="button" title="Edit article"><span class="icon-pen"></span></button>
              </form>
              <?php endif; ?>
            </aside>
          </div>
        </div>
      </article>
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