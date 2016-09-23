<?php require locate_template('Functions/FunctionVariables.php');
      require_once locate_template('Functions/SetLogin.php');
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
              <div class="m12">
                <h1 class="emphasized"><?php echo $name; ?></h1><br class="sizeS-hidden">
                <div itemprop="articleBody" class="grid">
                  <div class="m6">
                    <form method="post" action="<?php echo $formAction; ?>">
                      <fieldset>
                        <?php if ($errorLogin):
                              echo $errorLogin;
                              endif; ?>
                        <div class="input">
                          <label for="user_login"><?php echo $formUserLoginText; ?></label>
                          <input type="text" id="user_login" name="user_login" placeholder="<?php echo $formUserLoginPlaceholder; ?>" autofocus>
                        </div>
                        <div class="input-password">
                          <label for="user_password"><?php echo $formUserPasswordText; ?></label>
                          <input type="password" id="user_password" name="user_password" placeholder="<?php echo $formUserPasswordPlaceholder; ?>">
                          <input type="checkbox" title="See the password">
                        </div>
                        <div>
                          <input id="remember" type="checkbox" name="remember" checked="" class="switch">
                          <label for="remember"><?php echo $formSaveText; ?><span data-on="yes" data-off="no"></span></label>
                        </div>
                        <div>
                          <button class="button"><span class="icon-login"></span>&nbsp;&nbsp;<?php echo $formSignInText; ?></button>
                        </div>
                      </fieldset>
                    </form>
                    <?php if ($userRegistrationOpen): ?>
                    <div class="message-info">
                      <p><?php echo $message; ?></p>
                      <form action="<?php echo $siteUri; ?>/Register" method="post">
                        <button class="button"><span class="icon-arrow-right"></span>&nbsp;&nbsp;<?php echo $register; ?></button>
                      </form>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="m6 vertical">
                    <div class="icon-user surround zoom500"></div>
                  </div>
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