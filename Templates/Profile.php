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
      <article itemscope itemtype="https://schema.org/Article" class="article">
        <div id="index-article">
          <div class="wrap">
            <div class="grid">
              <h1 itemprop="name headline" class="emphasized"><?php echo $name; ?></h1>
            </div><br class="sizeS-hidden">
            <div itemprop="articleBody" class="grid">
              <div class="m2 sizeXS-m6 sizeS-m3">
                <div style="background-image:url(<?php echo $avatarImg; ?>)" class="avatar">
                  <div class="ratio"></div>
                </div>
              </div>
              <?php if ($userDescription): ?>
              <div class="m6 sizeS-m9">
                <p><em><?php echo $userDescription; ?></em></p>
              </div>
              <?php endif; ?>
              <div>
                <div class="columns">
                  <div class="list-stripe"><?php echo $userInfoList; ?></div>
                  <div class="list-stripe"><?php echo $loginLogout; ?></div>
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