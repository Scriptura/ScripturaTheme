<?php

// -----------------------------------------------------------------------------
// @section     Google analytics
// @description Code de suivi de l'API Google Analytics
// -----------------------------------------------------------------------------

// @note Le numéro de compte doit être renseigné à partir du panneau d'administration

if( get_option( 'scriptura_google_analytics' ) ) : ?>
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', '<?php echo get_option( 'scriptura_google_analytics' ); ?>', '<?php echo $siteUri; ?>');
ga('send', 'pageview');</script>
<?php endif;
