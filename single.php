<?php require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/SetSingle.php');
      $authorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );
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
                <h1 itemprop="name" class="h2 vmin emphasized"><?php echo $name; ?></h1>
              </div>
              <div class="grid6 sizeS-grid12">
                <div itemprop="articleBody" class="links protected"><?php echo $content; ?></div>
                <?php if ($capacityAdministrator OR ( ! $restrictedRead OR $restrictedRead AND $capacityRead ) AND ( ! $authorizedGroups OR $userGroup == $authorizedGroups )): ?>
                <aside class="button-group">
                  <div>
                    <button title="Print article" class="button cmd-print"><span class="icon-printer"></span></button>
                  </div>
                  <?php if ($capacityRead AND $commentsOpen AND is_single()): ?>
                  <div>
                    <button title="Comment article" id="comments" class="button"><span class="icon-bubbles"></span></button>
                  </div>
                  <?php endif;
                        if ($capacityEditPosts): ?>
                  <form action="<?php echo $editPost; ?>" method="post">
                    <button title="Edit article" class="button"><span class="icon-pen"></span></button>
                  </form>
                  <?php endif; ?>
                </aside>
                <?php endif; ?>
              </div>
              <?php if ($capacityAdministrator OR ( ! $restrictedRead OR $restrictedRead AND $capacityRead ) AND ( ! $authorizedGroups OR $userGroup == $authorizedGroups )): ?>
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
                <?php endif;
                      if ($restrictedRead): ?>
                <p class="message-info">
                  <?php _e( 'This content is only visible to connected users.', 'scriptura' ); ?>
                </p>
                <?php endif;
                      if ($authorizedGroups): ?>
                <p class="message-info">
                  <?php _e( 'This content is only visible to authorized users.', 'scriptura' ); ?>
                </p>
                <?php endif; ?>
              </aside>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </article>
    </main>
    <?php if (( $capacityAdministrator AND $comments ) OR ( $capacityRead AND ( $commentsOpen AND $capacityCommentator OR $commentsOpen AND $comments ) AND ( ! $authorizedGroups OR $userGroup == $authorizedGroups ) )): ?>
    <aside id="index-comments" class="aside">
      <div class="wrap">
        <h2 class="vmin emphasized"><?php echo $commentsTitle; ?><a href="#index-comments" class="anchor"></a></h2>
        <div class="grid">
          <?php echo $comments;
                if ($commentsOpen AND $capacityCommentator):
                echo $commentForm;
                endif; ?>
        </div>
      </div>
    </aside>
    <?php endif;
          if ($relation): ?>
    <aside class="aside">
      <div class="wrap">
        <h2 class="vmin emphasized"><?php echo $relationsTitle; ?></h2>
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
        <p>The site can not be displayed with this browser. Update your browser.</p>
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
<?php exit; ?>