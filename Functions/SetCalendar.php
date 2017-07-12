<?php

// -----------------------------------------------------------------------------
// @section     Set Single
// @description Configuration pour les pages d'articles
// -----------------------------------------------------------------------------

// @note Certaines fonctions WP ne peuvent être mises dans une variable en l'état. Recours aux fonctions php natives 'ob_start()' et 'ob_get_clean()' afin de contourner ce problème.

// @documentation
// - 'ob_start()' enclenche la temporisation de sortie
// - 'ob_get_clean()' lit le contenu courant du tampon de sortie puis l'efface

	$name = get_the_title();
	ob_start();
	echo '<div class="grid">';
	echo '<div class="m6">';
	echo '<ul class="list-stripe">';
	echo ScripturaGetDate( true, true, 'li' );
	echo ScripturaCalendarLiturgy( '', true, 'li' );
	//echo '<li>class-' . ScripturaGetSeason() . '</li>';
	echo '</ul>';
	echo '<hr>';
	echo '<ul class="list-stripe">';
	echo Moon\ScripturaMoonCalendar();
	echo '</ul>';
	echo '</div>';
	echo '<div class="m6">';
	echo Moon\ScripturaMoonPhases(25);
	echo '</div>';
	echo '</div>';
	$content = ob_get_clean();
