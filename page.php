<?php require_once locate_template('Functions/Variables.php');
      require_once locate_template('Functions/VariablesSingle.php');
      require_once locate_template('Functions/MainNav.php'); ?><!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <?php require_once locate_template('Functions/Head.php'); ?>
  </head>
  <body itemscope itemtype="https://schema.org/WebPage">
    <nav role="navigation" class="main-nav sizeNav-nav-bottom">
      <div class="wrap">
        <div class="brand-image"><a href="<?php echo $siteUri; ?>"><?php echo $siteName; ?></a></div>
        <div>
          <button></button>
          <?php echo $mainNav; ?>
        </div>
      </div>
    </nav>
    <?php echo $breadcrumb; ?>
    <main itemprop="mainContentOfPage">
      <article itemscope itemtype="https://schema.org/Article" class="article"><?php echo $image; ?>
        <div id="index-article">
          <div class="wrap">
            <div class="grid print-area">
              <div>
                <h1 class="emphasized"><?php echo $name; ?></h1>
              </div>
              <div itemprop="articleBody"><?php echo $content; ?></div>
              <aside class="button-group no-print">
                <button title="Print article" class="button cmd-print"><span class="icon-printer"></span></button>
                <?php if (current_user_can('edit_posts')): ?>
                <form action="<?php echo $editPost; ?>" method="post" target="_blank">
                  <button title="Edit article" class="button"><span class="icon-pen"></span></button>
                </form>
                <?php endif; ?>
              </aside>
            </div>
          </div>
        </div>
      </article>
    </main>
    <footer id="index-footer" class="section footer">
      <svg xmlns="http://www.w3.org/2000/svg" width="1000" height="1000" viewBox="0 0 1000 1000" enable-background="new 0 0 141.732 141.732" fill="#777777" class="width10 height10 center">
        <path d="M92.431 302.237c29.836-16.018 90.613-55.803 225.968-57.455 65.777-.809 38.124 34.802 51.376 40.88 13.262 6.07 35.358-19.34 25.427-66.299-9.957-46.959-143.659-51.385-246.969-1.661-103.318 49.724-226.185 140.911-83.421 251.943 109.388 85.082 317.868 162.434 226.524 191.896-97.17 31.341-195.949-11.783-221.733-22.105-25.793-10.314-92.091 21.366-55.255 58.203 36.837 36.828 250.473 30.201 308.667 4.418 58.185-25.775 88.396-83.239-8.844-150.277-97.248-67.038-162.808-81.769-263.726-161.33-30.419-23.975.565-65.977 41.985-88.213zm882.879-148.625c-18.775 19.888-58.559 39.785-161.321 54.15-3.322-9.948-4.426-46.411 6.626-87.3 11.053-40.889 1.104-48.62-15.462-15.47-16.583 33.149-30.949 103.866-30.949 103.866-51.933 7.731-142.633-24.714-171.269-34.254-6.635-2.209-47.524-14.366-7.731 19.888 39.767 34.254 88.396 43.098 169.052 56.351-24.306 230.942-13.253 509.399 27.627 595.594 40.88 86.187 36.471 51.933 29.836 11.044-43.428-267.822-30.941-403.315-17.679-606.638 98.361 3.313 154.703-44.193 182.331-82.874 27.627-38.68 7.722-34.245-11.061-14.357zm-87.283 76.247c-19.897 5.522-32.054 6.626-37.567-2.217-4.157-6.626 13.253-13.253 34.254-17.679 20.984-4.418 32.036-7.731 33.149-3.305 1.104 4.409-9.948 17.67-29.836 23.201zm35.358 158.017c-53.055 8.835-46.42-30.949-46.42-30.949s45.298 0 55.255-41.985c9.94-41.985-24.314-69.612-58.568-38.68-34.254 30.949-54.046 122.971 24.688 137.024 30.941 5.522 71.647-33.176 25.045-25.41zm-52.307-86.561c14.001-22.836 39.785-22.097 43.463-10.314 3.687 11.783-2.757 39.958-16.931 46.411-36.376 16.54-40.532-13.262-26.532-36.097zm-336.642 137.746c-2.226-24.306-9.966-54.507-14.366-84.343-11.618-78.369-55.255-49.724-70.725-11.053-8.992 22.497-18.462 57.681-29.836 90.97-10.322 30.201 15.462 33.889 21.358 2.948 1.844-9.627 3.435-21.749 36.828-19.888 26.523 1.47 36.837-.73 37.941 22.105 1.67 34.506 21.001 23.575 18.801-.739zm-46.428-37.558c-13.244 0-34.61 1.47-33.141-16.201 1.583-19.062 13.262-52.298 30.201-52.298 16.94 0 22.836 31.671 24.323 47.141 1.461 15.462-8.122 21.358-21.384 21.358zm141.45 9.574c5.618-13.627 9.948-41.985 22.105-26.514 12.14 15.47 17.67 47.515 40.872 6.635 23.21-40.889 3.331-87.3-6.626-100.561-9.948-13.253-33.149-16.566-14.366 15.47 18.792 32.054 5.531 58.568 1.113 55.255-4.426-3.305-33.149-26.514-45.315-5.522-12.148 21.001-17.67 38.671-17.67 53.037s12.14 20.984 19.888 2.2zm-159.121 70.716c-24.314-1.104-36.463 18.784-41.993 71.83-16.566-2.209-54.142 9.94-4.418 26.514 1.113 26.514 2.217 40.889 13.262 43.098 11.053 2.2 12.148-37.576 12.148-37.576 23.201 0 55.255-4.418 60.768-44.202 5.539-39.767-15.462-58.551-39.767-59.664zm23.21 57.464c-2.209 14.366-18.053 31.68-38.671 26.523-11.992-3-6.635-33.158-6.635-33.158 5.522-18.784 12.148-33.149 32.045-30.941 19.879 2.217 15.462 23.21 13.262 37.576zm137.024 112.71c-12.157-9.948-23.21-21.001-53.055-50.829 7.74-1.104 36.463-24.314 43.089-34.254 25.871-38.793-8.835-69.621-36.454-64.09-27.619 5.531-46.411 32.045-50.837 50.829-4.409 18.784-3.305 50.829-5.513 93.918-2.113 41.072 28.732 41.993 25.41-8.835-.939-14.383 3.322-19.888 11.053-16.575 7.731 3.305 24.306 17.67 39.767 39.776 15.479 22.105 38.68 0 26.54-9.94zm-74.038-70.725c-12.366-12.348-3.322-41.985 14.357-53.037 17.679-11.053 53.046 6.635 30.949 36.463-22.105 29.836-37.576 24.314-45.307 16.575zm95.03 19.896c1.913-28.758 10.418-87.717 32.045-68.508 9.94 8.835-2.217 37.567-2.217 57.464s0 47.515-12.148 46.402c-12.175-1.104-18.792-18.792-17.679-35.358zm33.141-112.71c-8.905 0-17.67 11.053-17.67 19.897 0 8.835 8.835 11.053 16.566 11.053 7.731 0 12.157-8.844 12.157-16.575.009-7.748-6.626-14.375-11.053-14.375zm-132.598-91.717c1.922-28.758 10.427-87.717 32.045-68.508 9.948 8.844-2.209 37.576-2.209 57.464 0 19.888 0 47.515-12.148 46.411-12.157-1.104-18.792-18.784-17.688-35.367zm33.15-112.71c-8.905 0-17.679 11.053-17.679 19.888s8.844 11.053 16.575 11.053 12.148-8.844 12.148-16.575c0-7.74-6.626-14.366-11.044-14.366z"></path>
      </svg>
      <div class="terms-use">
        <div class="message-warning">
          <p>En parcourant ce site vous acceptez nos conditions générales d'utilisation...</p>
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
    <?php wp_footer();
          require_once locate_template('Functions/GoogleAnalytics.php'); ?>
  </body>
</html>