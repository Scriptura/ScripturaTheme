<?php require locate_template('Functions/FunctionVariables.php');
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
      <article itemprop="mainEntityOfPage" itemscope itemtype="https://schema.org/Article" class="article"><?php echo $image; ?>
        <div id="index-article">
          <div class="wrap">
            <div class="grid">
              <div class="m12">
                <h1 itemprop="name headline" class="h2 vmin emphasized"><?php echo $name; ?></h1>
              </div>
              <div class="grid6 sizeS-grid12">
                <div itemprop="articleBody" class="links protected"><?php echo $content; ?></div>
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
              <aside class="m6 sizeS-m12">
                <?php if ($articleDescription): ?>
                <p itemprop="description" class="message"><?php echo $articleDescription; ?></p>
                <?php endif;
                      if ($reference): ?>
                <p class="message-source"><?php echo $reference; ?></p>
                <?php endif; ?>
                <p class="message-date"><?php echo $published; ?></p>
                <?php if ($keywords): ?>
                <p class="message-keyword"><?php echo $keywords; ?></p>
                <?php endif; ?>
              </aside>
            </div>
          </div>
        </div>
      </article>
    </main>
    <?php if ($capacityRead):
          if ($comments OR $capacityCommentator AND $commentsOpen): ?>
    <aside id="index-comments" class="aside">
      <div class="wrap">
        <h2 class="emphasized"><?php echo $commentsTitle; ?><a href="#index-comments" class="anchor"></a></h2>
        <div class="grid">
          <?php echo $comments;
                endif;
                if ($capacityCommentator AND $commentsOpen):
                echo $commentForm;
                endif; ?>
        </div>
      </div>
    </aside>
    <?php endif; ?>
    <div class="ajax-window-comments"></div>
    <?php if ($relation): ?>
    <aside class="aside">
      <div class="wrap">
        <h2 class="emphasized"><?php echo $relationsTitle; ?></h2>
        <div class="relationship"><?php echo $relation; ?></div>
      </div>
    </aside>
    <?php endif; ?>
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