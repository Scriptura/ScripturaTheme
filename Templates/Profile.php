<?php require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/SetProfile.php');
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
            <div itemprop="articleBody">
              <h1 class="emphasized"><?php echo $name; ?></h1>
              <div class="grid">
                <div class="m2 sizeXS-m6 sizeS-m3">
                  <div style="background-image:url(<?php echo $gravatarUri; ?>)" class="avatar">
                    <div class="ratio"></div>
                  </div>
                </div>
                <div class="m6 sizeS-m9">
                  <?php if ($userDescription): ?>
                  <p><em><?php echo $userDescription; ?></em></p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="columns">
                <div class="list-stripe">
                  <?php if ($userLogin): ?>
                  <p><span class="icon-ampersand"></span>&nbsp;&nbsp;Identifiant&nbsp;: <?php echo $userLogin; ?></p>
                  <?php endif;
                        if ($userEmail): ?>
                  <p><span class="icon-at"></span>&nbsp;&nbsp;Email&nbsp;: <?php echo $userEmail; ?></p>
                  <?php endif;
                        if ($userFirstName): ?>
                  <p><span class="icon-user"></span>&nbsp;&nbsp;Prénom&nbsp;: <?php echo $userFirstName; ?></p>
                  <?php endif;
                        if ($userLastName): ?>
                  <p><span class="icon-user"></span>&nbsp;&nbsp;Nom&nbsp;: <?php echo $userLastName; ?></p>
                  <?php endif;
                        if ($userDisplayName): ?>
                  <p><span class="icon-user"></span>&nbsp;&nbsp;Pseudo&nbsp;: <?php echo $userDisplayName; ?></p>
                  <?php endif;
                        if ($userMetaGroup): ?>
                  <p><span class="icon-radio-unchecked"></span>&nbsp;&nbsp;Group&nbsp;: <?php echo $userMetaGroup; ?></p>
                  <?php endif; ?>
                </div>
                <div class="list-stripe">
                  <?php if ($capacityEditPosts): ?><a href="<?php echo $adminUri; ?>"><span class="icon-login"></span>&nbsp;&nbsp;<?php echo $textAdmin; ?></a>
                  <?php endif; ?><a href="<?php echo $logoutUri; ?>"><span class="icon-logout"></span>&nbsp;&nbsp;<?php echo $textLogout; ?></a>
                </div>
              </div>
            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo $templateUri; ?>/Scripts/Vendors/JQuery.js"><\/script>')</script>
    <script>var templateUri = '<?php echo $templateUri; ?>'</script>
    <script src="<?php echo $templateUri; ?>/Public/Scripts/Main.js"></script>
    <?php require locate_template('Functions/GoogleAnalytics.php'); ?>
  </body>
</html>
<?php die(); ?>