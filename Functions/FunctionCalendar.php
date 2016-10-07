<?php

// -----------------------------------------------------------------------------
// @section     Function Calendar
// @description Calendrier
// -----------------------------------------------------------------------------


// @subsection  Additional Information
// @description Informations supplémentaires sur un article
// -----------------------------------------------------------------------------

// @link http://syframework.alwaysdata.net/3b9
function ScripturaGetDate( $html = '' )
{
	// @param $html, valeur d'une balise html ('div', 'span', 'p', etc...)
	date_default_timezone_set( 'Europe/Paris' );
	$day = [
		'Dimanche',
		'Lundi',
		'Mardi',
		'Mercredi',
		'Jeudi',
		'Vendredi',
		'Samedi'
	];
	$month = [
		'Janvier',
		'Février',
		'Mars',
		'Avril',
		'Mai',
		'Juin',
		'Juillet',
		'Août',
		'Septembre',
		'Octobre',
		'Novembre',
		'Décembre'
	];
	//$date = date( 'w' ) . ' ' . date( 'j' ) . ' ' . date( 'n' );
	$date = '';
	if ( $html )
		$date .= '<' . $html . '>';
	$date .= $day[ date( 'w' ) ] . ' ' . date( 'j' ) . ' ' . $month[ date( 'n' ) - 1 ];
	if ( $html )
		$date .= '</' . $html . '>' . PHP_EOL;
	return $date;
}
//var_dump( ScripturaGetDate( 'span' ) );exit;


// @link https://css-tricks.com/snippets/php/change-graphics-based-on-season/
// @link http://syframework.alwaysdata.net/3c2
function ScripturaGetSeason( $day = '' )
{
	$day = (int) $day; // Convertir une chaîne de caractère (string) en entier (integer)
	if ( ! $day )
		$day = date( 'z' ); // Jour de l'année 
	if ( $day < 0 OR $day > 365 ) // De 1 à 366 jours max., le premier jour commence par 0.
		return 'Date error';
	// Days of spring
	$spring_starts = date( 'z', strtotime( 'March 21' ) );
	$spring_ends   = date( 'z', strtotime( 'June 20' ) );
	// Days of summer
	$summer_starts = date( 'z', strtotime( 'June 21' ) );
	$summer_ends   = date( 'z', strtotime( 'September 22' ) );
	// Days of autumn
	$autumn_starts = date( 'z', strtotime( 'September 23' ) );
	$autumn_ends   = date( 'z', strtotime( 'December 20' ) );
	// Affichage de la saison :
	if( $day >= $spring_starts AND $day <= $spring_ends ) {
		$season = 'spring';
	} elseif ( $day >= $summer_starts AND $day <= $summer_ends ) {
		$season = 'summer';
	} elseif ( $day >= $autumn_starts AND $day <= $autumn_ends ) {
		$season = 'autumn';
	} else {
		$season = 'winter';
	}
	return $season;
}
//var_dump( ScripturaGetSeason( 1 ) );exit;


// @link http://syframework.alwaysdata.net/3bs
function ScripturaCalendarLiturgy( $date = '', $links = '', $html = '' )
{
	// @param $date jour/mois sur deux chiffres passés obligatoirement en chaine de caractères (ex : '0101')
	// @param $links bouléen, true si affichage des liens
	// @param $html, valeur d'une balise html ('div', 'span', 'p', etc...)
	if ( $date ) {
		if ( strlen( $date ) != 4 )
			return 'Date Error: the string must consist of 4 numbers';
		if ( ! ctype_digit( $date ) )
			return 'Date Error: the string is not only digital';
	} else {
		$calendar = date( 'dm' ); // Si date non renseignée, alors date du jour
	}
	// Commémorations fixes :
	$item[ '0101' ] = 'Sainte Marie, Mère de Dieu';
	$item[ '0201' ] = 'S. Basile le Grand, évêque de Césarée, docteur de l\'Église et S. Grégoire de Nazianze, évêque de Constantinople, docteur de l\'Église';
	$item[ '0301' ] = 'Saint Nom de Jésus';
	$item[ '0501' ] = 'Ss. Longin, Eugène et Vindémial, évêques';
	//$item[ '0601' ] = 'Épiphanie du Seigneur'; // Pas pour la France
	$item[ '0701' ] = 'S. Raymond de Penyafort, prêtre, Dominicain';
	$item[ '0801' ] = 'Ss. Quodvultdeus et Dcogratias, évêques';
	$item[ '1101' ] = 'Ss. Victor <abbr title="premier">I<sup>er</sup></abbr>, Miltiade et Gélase <abbr title="premier">I<sup>er</sup></abbr>, papes';
	$item[ '1201' ] = 'Ste Marguerite Bourgeoys, vierge, fondatrice';
	$item[ '1301' ] = 'S. Hilaire, évêque de Poitiers, docteur de l\'Église';
	$item[ '1501' ] = 'S. Remi, évêque de Reims';
	$item[ '1701' ] = 'S. Antoine, abbé en Haute-Égypte';
	$item[ '2001' ] = 'S. Fabien, pape et martyr, et S. Sébastien, martyr à Rome';
	$item[ '2101' ] = 'Ste Agnès, vierge et martyre';
	$item[ '2201' ] = 'S. Vincent, diacre, martyr à Valence';
	$item[ '2401' ] = 'S. François de Sales, évêque de Genève, docteur de l\'Église';
	$item[ '2501' ] = 'Conversion de S. Paul, apôtre';
	$item[ '2601' ] = 'S. Timothée et S. Tite, évêques, compagons de S. Paul';
	$item[ '2701' ] = 'S. Angèle Mérici, vierge, fondatrice des Ursulines';
	$item[ '2801' ] = 'S. Thomas d\'Aquin, prêtre, Dominicain, docteur de l\'Église';
	$item[ '3101' ] = 'S. Jean Bosco, prêtre, fondateur des Salésiens';
	$item[ '0202' ] = 'Présentation du Seigneur au Temple';
	$item[ '0302' ] = 'S. Blaise, évêque de Sébaste et Martyr&nbsp;;<br> S. Anchaire, évêque de Hambourg';
	$item[ '0402' ] = 'Ste Célérina et ses compagnons, martyrs';
	$item[ '0502' ] = 'Ste Agathe, vierge et martyre';
	$item[ '0602' ] = 'S. Paul Miki, prêtre, et ses compagnons, martyrs&nbsp;;<br> S. Amand, évêque de Maastricht';
	$item[ '0802' ] = 'S. Jérôme Émilien, fondateur&nbsp;;<br> Ste Joséphine Bakhita, vierge, esclave soudanaise puis religieuse';
	$item[ '1002' ] = 'Ste Scholastique, sœur de S. Benoît, vierge, moniale';
	$item[ '1002' ] = 'Notre-Dame de Lourdes';
	$item[ '1402' ] = 'S. Cyrille, moine, et son frère S. Méthode, évêque de Moravie';
	$item[ '1502' ] = 'St Claude de la Colombière';
	$item[ '1702' ] = 'Les sept saints fondateurs des Servites de Marie, à Florence';
	$item[ '1802' ] = 'Ste Bernadette Soubirous, vierge';
	$item[ '2102' ] = 'S. Pierre Damien, docteur de l\'Église, cardinal-évêque d\'Ostie';
	$item[ '2202' ] = 'Chaire de S. Pierre, apôtre';
	$item[ '1002' ] = 'S. Polycarpe, évêque de Smyrne et martyr';
	$item[ '0403' ] = 'S. Casimir, prince de Lituanie';
	$item[ '0703' ] = 'Ste Perpétue et Ste Félicité, martyres';
	$item[ '0803' ] = 'S. Jean de Dieu, fondateur des frères hospitaliers';
	$item[ '0903' ] = 'Ste Françoise Romaine, mère de famille puis religieuse';
	$item[ '1703' ] = 'S. Patrice, évêque d\'Irlande';
	$item[ '1803' ] = 'S. Cyrille, évêque de Jérusalem, docteur de l\'Église';
	$item[ '1903' ] = 'S. Joseph, époux de la Vierge Marie';
	$item[ '2303' ] = 'S. Turibio de Mogrovejo, évêque de Lima';
	$item[ '2503' ] = 'Annonciation du Seigneur'; //voir conditions php plus loin...
	$item[ '0204' ] = 'S. François de Paule, ermite italien';
	$item[ '0404' ] = 'S. Isidore, évêque de Séville, docteur de l\'Église';
	$item[ '0504' ] = 'S. Vincent Ferrier, Dominicain espagnol';
	$item[ '0704' ] = 'S. Jean-Baptiste de la Salle, prêtre, fondateur des Écoles chrétiennes';
	$item[ '1104' ] = 'S. Stanislas, évêque de Cracovie et martyr';
	$item[ '1304' ] = 'S. Martin <abbr title="premier">I<sup>er</sup></abbr>, pape, martyr';
	$item[ '2104' ] = 'S. Anselme, évêque de Cantorbéry, docteur de l\'Église';
	$item[ '2304' ] = 'S. Georges, martyr&nbsp;;<br> S. Adalbert, évêque de Prague, martyr';
	$item[ '2404' ] = 'S. Fidèle de Sigmaringen, Capucin, martyr&nbsp;;<br> Robert de Turlande, fondateur de l\'abbaye de la Chaise-Dieu';
	$item[ '2504' ] = 'S. Marc, évangéliste';
	$item[ '2804' ] = 'S. Pierre Chanel, prêtre, Mariste français, 1er martyr d\'Océanie&nbsp;;<br> S. Louis-Marie Grignion de Montfort, prêtre, fondateur';
	$item[ '2904' ] = 'Ste Catherine de Sienne, vierge, tertiaire dominicaine, docteur de l\'Église';
	$item[ '3004' ] = 'S. Pie <abbr title="cinq">V</abbr>, pape&nbsp;;<br> Notre-Dame d\'Afrique';
	$item[ '0105' ] = 'S. Joseph, travailleur';
	$item[ '0205' ] = 'S. Athanase, évêque d\'Alexandrie, docteur de l\'Église';
	$item[ '0305' ] = 'S. Philippe et S. Jacques, apôtes';
	$item[ '0605' ] = 'S. Jacques, diacre, Marien, lecteur, et leur compagnons, martyrs';
	$item[ '1205' ] = 'S. Nérée et S. Achille, martyrs&nbsp;;<br> S. Pancrace, martyr';
	$item[ '1305' ] = 'Notre-Dame de Fatima';
	$item[ '1405' ] = 'S. Matthias, apôtre';
	$item[ '1805' ] = 'S. Jean 1er, pape et martyr';
	$item[ '1905' ] = 'S. Yves, prêtre et juge';
	$item[ '2005' ] = 'S. Bernardin de Sienne, prêtre, Franciscain';
	$item[ '2105' ] = 'S. Christophe Magallanès, prêtre, et ses compagnons, martyrs au Mexique';
	$item[ '2205' ] = 'Ste Rita de Cascia, religieuse augustine';
	$item[ '2505' ] = 'S. Bède le Vénérable, prêtre et moine, docteur de l\'Église&nbsp;;<br> S. Grégoire VII, pape&nbsp;;<br> Ste Marie-Madeleine de Pazzi, Carmélite';
	$item[ '2605' ] = 'S. Philippe Néri, prêtre, fondateur de l\'Oratoire';
	$item[ '2705' ] = 'S. Augustin, évêque de Canterbury';
	$item[ '3005' ] = 'Ste Jeanne d\'Arc, vierge';
	$item[ '3105' ] = 'Visitation de la Vierge Marie';
	$item[ '0106' ] = 'S. Justin, philosophe, martyr';
	$item[ '0206' ] = 'S. Marcellin et S. Pierre, martyrs&nbsp;;<br> S. Photin, évêque de Lyon, Ste Blandine, vierge, et leurs compagnons, martyrs';
	$item[ '0306' ] = 'S. Charles Lwanga et ses compagnons, martyrs en Ouganda';
	$item[ '0406' ] = 'Ste Clotilde, reine des Francs&nbsp;;<br> S. Optat, évêque de Milève';
	$item[ '0506' ] = 'S. Boniface, évêque de Mayenne et martyr';
	$item[ '0606' ] = 'S. Norbert, évêque de Magdebourg, fondateur des Prémontrés';
	$item[ '0906' ] = 'S. Éphrem, diacre, docteur de l\'Église';
	$item[ '1106' ] = 'S. Barnabé, apôtre';
	$item[ '1306' ] = 'S. Antoine de Padoue, prêtre, Franciscain portugais, docteur de l\'Église';
	$item[ '1906' ] = 'S. Romuald, abbé, fondateur des Camaldules';
	$item[ '2106' ] = 'S. Louis de Gonzague, novice jésuite';
	$item[ '2206' ] = 'S. Paulin, Bordelais, évêque de Nole&nbsp;;<br> S. Jean Fisher, évêque de Rochester, et S. Thomas More, chancelier d\'Angleterre, martyrs à Londres';
	$item[ '2406' ] = 'Nativité de saint Jean Baptiste';
	$item[ '2606' ] = 'S. Josemaría Escrivá de Balaguer, prêtre';
	$item[ '2706' ] = 'S. Cyrille, évêque d\'Alexandrie, docteur de l\'Église';
	$item[ '2806' ] = 'S. Irénée, évêque de Lyon et martyr';
	$item[ '2906' ] = 'S. Pierre et S. Paul, apôtres';
	$item[ '3006' ] = 'Premiers martyrs de l\'Église de Rome';
	$item[ '0307' ] = 'S. Thomas, apôtre';
	$item[ '0407' ] = 'Ste Élisabeth, reine du Portugal';
	$item[ '0507' ] = 'S. Antoine-Marie Zaccaria, prêtre, fondateur des Barnabites';
	$item[ '0607' ] = 'Ste Maria Goretti, vierge, martyre';
	$item[ '0907' ] = 'S. Augustin Zaho Rong, prêtre et ses compagnons, martyrs';
	$item[ '1007' ] = 'Ste Marcienne de Dellys, vierge et martyre';
	$item[ '1107' ] = 'S. Benoît, abbé';
	$item[ '1307' ] = 'S. Henri, empereur d\'Allemagne';
	$item[ '1407' ] = 'S. Camille de Lellis, prêtre, fondateur de religieux hospitaliers';
	$item[ '1507' ] = 'S. Bonaventure, Franciscain, évêque d\'Albano, docteur de l\'Église';
	$item[ '1607' ] = 'Notre-Dame du Mont-Carmel';
	$item[ '1707' ] = 'S. Spérat et ses compagnons, martyrs à Carthage';
	$item[ '2007' ] = 'S. Apollinaire, évêque de Ravenne et martyr';
	$item[ '2107' ] = 'S. Laurent de Brindisi, prêtre, Capucin, docteur de l\'Église';
	$item[ '2207' ] = 'Ste Marie-Madeleine, disciple du Seigneur';
	$item[ '2307' ] = 'Ste Brigitte de Suède, mère de famille puis religieuse';
	$item[ '2407' ] = 'S. Charbel Maklouf, prêtre, moine';
	$item[ '2507' ] = 'S. Jacques le Majeur, apôtre';
	$item[ '2607' ] = 'Ste Anne et S. Joachim, parents de la Vierge Marie';
	$item[ '2907' ] = 'Ste Marthe, hôtesse du Seigneur';
	$item[ '3007' ] = 'S. Pierre Chrysologue, évêque de Ravenne, docteur de l\'Église';
	$item[ '3107' ] = 'S. Ignace de Loyola, prêtre, fondateur des Jésuites';
	$item[ '0108' ] = 'S. Alphonse de Liguori, évêque, fondateur des Rédemptoristes, docteur de l\'Église';
	$item[ '0208' ] = 'S. Eusèbe, évêque de Verseil&nbsp;;<br> S. Pierre-Julien Eymard, prêtre, fondateur des Prêtres du Saint-Sacrement';
	$item[ '0408' ] = 'S. Jean-Marie Vianney, prêtre, curé d\'Ars';
	$item[ '0508' ] = 'Dédicace de la basilique de Sainte-Marie Majeure';
	$item[ '0608' ] = 'Transfiguration du Seigneur';
	$item[ '0708' ] = 'S. Sixte II, pape, et ses compagnons, martyrs&nbsp;;<br> S. Gaétan, prêtre, fondateur des Théatins&nbsp;;<br> Ste Julienne du Mont-Cornillon, vierge';
	$item[ '0808' ] = 'S. Dominique, prêtre, fondateur des Frères Prêcheurs';
	$item[ '0908' ] = 'Ste Thérèse-Bénédicte de la Croix (Édith Stein), Carmélite, martyre';
	$item[ '1008' ] = 'S. Laurent, diacre, martyr à Rome';
	$item[ '1108' ] = 'Ste Claire, vierge, fondatrice des Pauvres Dames ou Clarisses';
	$item[ '1208' ] = 'Ste Jeanne-Françoise de Chantal, mère de famille puis religieuse, fondatrice de la Visitation';
	$item[ '1308' ] = 'S. Pontien, pape, et S. Hyppolyte, prêtre de Rome, martyrs&nbsp;;<br> S. Jean Berchmans, Jésuite';
	$item[ '1408' ] = 'S. Maximilien Kolbe, prêtre franciscain et martyr';
	$item[ '1508' ] = 'Assomption de la Vierge Marie';
	$item[ '1608' ] = 'S. Étienne de Hongrie';
	$item[ '1908' ] = 'S. Jean Eudes, prêtre, fondateur';
	$item[ '2008' ] = 'S. Bernard, Cistercien, abbé de Clairvaux, docteur de l\'Église';
	$item[ '2108' ] = 'S. Pie X, pape';
	$item[ '2208' ] = 'Marie Reine de l\'univers';
	$item[ '2308' ] = 'Ste Rose de Lima, vierge, tertiaire dominicaine&nbsp;;<br> Ste Émilie de Vialar, vierge';
	$item[ '2408' ] = 'S. Barthélemy, apôtre';
	$item[ '2508' ] = 'S. Louis, roi de France&nbsp;;<br> S. Joseph de Calasanz, prêtre, fondateur';
	$item[ '2608' ] = 'S. Césaire, évêque d\'Arles';
	$item[ '2708' ] = 'S. Monique, mère de S. Augustin';
	$item[ '2808' ] = 'S. Augustin, évêque d\'Hippone, docteur de l\'Église';
	$item[ '2908' ] = 'Martyr de S. Jean Baptiste';
	$item[ '3008' ] = 'Ss. Alype et Possidius, évêques';
	$item[ '0309' ] = 'S. Grégoire le Grand, pape, docteur de l\'Église';
	$item[ '0809' ] = 'Nativité de la Vierge Marie';
	$item[ '0909' ] = 'S. Pierre Claver, prêtre';
	$item[ '1009' ] = 'S. Némésianus et ses compagnons, martyrs';
	$item[ '1209' ] = 'Le Saint Nom de Marie';
	$item[ '1309' ] = 'S. Jean Chrysostome, évêque et docteur de l\'Église';
	$item[ '1409' ] = 'La Croix glorieuse';
	$item[ '1509' ] = 'Notre-Dame des Douleurs';
	$item[ '1609' ] = 'S. Corneille, pape, et S. Cyprien, évêque, martyrs';
	$item[ '1709' ] = 'S. Robert Bellarmin, évêque et docteur de l\'Église';
	$item[ '1809' ] = 'S. Lambert, évêque et martyr';
	$item[ '1909' ] = 'S. Janvier, évêque et martyr';
	$item[ '2009' ] = 'Ss. André Kim Tae-gon, prêtre, Paul Chong Ha-sang et leurs compagnons, martyrs';
	$item[ '2109' ] = 'S. Matthieu, apôtre et évangéliste';
	$item[ '2209' ] = 'S. Maurice et ses compagnons, martyrs';
	$item[ '2509' ] = 'S. Nicolas de Flüe, ermite';
	$item[ '2609' ] = 'S. Côme et S. Damien, martyrs';
	$item[ '2709' ] = 'S. Vincent de Paul, prêtre';
	$item[ '2809' ] = 'S. Venceslas, martyr, S. Laurent Ruiz et ses compagnons, martyrs';
	$item[ '2909' ] = 'S. Michel, S. Gabriel, S. Raphaël, archanges';
	$item[ '3009' ] = 'S. Jérôme, prêtre et docteur de l\'Église';
	$item[ '0110' ] = 'Ste Thérèse de l\'Enfant-Jésus et de la Sainte Face, vierge et docteur de l\'Église';
	$item[ '0210' ] = 'Les Saints Anges Gardiens';
	$item[ '0410' ] = 'S. François d\'Assise';
	$item[ '0610' ] = 'S. Bruno, prêtre';
	$item[ '0710' ] = 'Notre-Dame du Rosaire';
	$item[ '0910' ] = 'S. Denis et ses compagnons, martyrs, S. Jean Léonardi, prêtre';
	$item[ '1410' ] = 'S. Calliste <abbr title="premier">I<sup>er</sup></abbr>, pape et martyr';
	$item[ '1510' ] = 'Ste Thérèse d\'Avila, vierge et docteur de l\'Église';
	$item[ '1610' ] = 'Ste Edwige, religieuse, Ste Marguerite-Marie Alacoque, vierge';
	$item[ '1710' ] = 'S. Ignace d\'Antioche, évêque et martyr';
	$item[ '1810' ] = 'S. Luc, évangéliste';
	$item[ '1910' ] = 'S. Jean de Brébeuf et S. Isaac Jogues, prêtres, et leur compagnons, martyrs';
	$item[ '2310' ] = 'S. Jean de Capistran, prêtre';
	$item[ '2410' ] = 'S. Antoine-Marie Claret, évêque';
	$item[ '2510' ] = 'Dédicace des églises consacrées dont on ne connaît pas la date de consécration';
	$item[ '2810' ] = 'S. Simon et S. Jude, apôtres';
	$item[ '3010' ] = 'Ss. Marcel et Maximilien, martyrs';
	$item[ '0111' ] = 'Tous les Saints';
	$item[ '0211' ] = 'Commémoration de tous les fidèles défunts';
	$item[ '0311' ] = 'S. Martin de Porrès, frère dominicain';
	$item[ '0411' ] = 'S. Charles de Borromée, cardinal, évêque de Milan';
	$item[ '0711' ] = 'S. Willibrord, évêque d\'Utrecht';
	$item[ '0911' ] = 'Dédicace de la Basilique du Latran';
	$item[ '1011' ] = 'S. Léon le Grand, pape, docteur de l\'Église';
	$item[ '1111' ] = 'S. Martin, évêque de Tours';
	$item[ '1211' ] = 'S. Josaphat, évêque de Polotsk, matryr';
	$item[ '1511' ] = 'S. Albert le Grand, Dominicain, évêque de Ratisbonne, docteur de l\'Église';
	$item[ '1611' ] = 'Ste Marguerite, reine d\'Écosse&nbsp;;<br>Ste Gertrude, vierge moniale';
	$item[ '1711' ] = 'Ste Élisabeth de Hongrie, duchesse de Thuringe';
	$item[ '1811' ] = 'Dédicace des basiliques de S. Pierre et de S. Paul apôtres';
	$item[ '2111' ] = 'Présentation de la Vierge Marie au Temple';
	$item[ '2211' ] = 'Ste Cécile, vierge et martyre';
	$item[ '2311' ] = 'S. Clément <abbr title="premier">I<sup>er</sup></abbr>, pape et martyr';
	$item[ '2411' ] = 'S. André Dung-Lac, prêtre, et ses compagnons, martyrs';
	$item[ '2511' ] = 'Ste Catherine d\'Alexandrie, vierge et martyre';
	$item[ '3011' ] = 'S. André, Apôtre';
	$item[ '0312' ] = 'S. François Xavier, prêtre, Jésuite';
	$item[ '0412' ] = 'S. Jean de Damas, prêtre, docteur de l\'Église';
	$item[ '0512' ] = 'Ste Crispine, martyre';
	$item[ '0612' ] = 'S. Nicolas, évêque de Myre';
	$item[ '0712' ] = 'S. Ambroise, évêque de Milan, docteur de l\'Église';
	$item[ '0812' ] = 'Immaculée conception de la Vierge Marie';
	$item[ '1112' ] = 'S. Damase <abbr title="premier">I<sup>er</sup></abbr>, pape';
	$item[ '1312' ] = 'Ste Lucie, vierge et martyre';
	$item[ '1412' ] = 'S. Jean de la Croix, prêtre, Carme, docteur de l\'Église';
	$item[ '1512' ] = 'S. Pierre Canisius, prêtre, docteur de l\'Église';
	$item[ '2312' ] = 'S. Jean de Kenty, prêtre';
	$item[ '2512' ] = 'Nativité du Seigneur';
	$item[ '2612' ] = 'S. Étienne, premier martyr';
	$item[ '2712' ] = 'S. Jean, apôtre et évangéliste';
	$item[ '2812' ] = 'Les Saints Innocents, martyrs';
	$item[ '2912' ] = 'S. Thomas Becket, évêque de Cantorbéry et martyr';
	$item[ '3112' ] = 'S. Sylvestre <abbr title="premier">I<sup>er</sup></abbr>, pape';
	// Lien associé à une commémoration fixe :
	$link[ '0101' ] = 'https://christus.fr/a-propos-de-marie-mere-de-dieu/';
	$link[ '0201' ] = 'https://christus.fr/basile-de-cesaree';
	$link[ '0301' ] = 'https://christus.fr/litanies-du-saint-nom-de-jesus';
	$link[ '0501' ] = '';
	//$link[ '0601' ] = 'https://christus.fr/l-etoile-de-l-epiphanie-benoit-xvi'; // Pas pour la France
	$link[ '0701' ] = '';
	$link[ '0801' ] = '';
	$link[ '1101' ] = '';
	$link[ '1201' ] = '';
	$link[ '1301' ] = '';
	$link[ '1501' ] = '';
	$link[ '1701' ] = 'https://christus.fr/antoine-le-grand';
	$link[ '2001' ] = '';
	$link[ '2101' ] = '';
	$link[ '2201' ] = '';
	$link[ '2401' ] = 'https://christus.fr/francois-de-sales';
	$link[ '2501' ] = 'https://christus.fr/la-conversion-de-saint-paul';
	$link[ '2601' ] = 'https://christus.fr/timothee-et-tite';
	$link[ '2701' ] = 'https://christus.fr/angele-merici';
	$link[ '2801' ] = 'https://christus.fr/thomas-aquinas';
	$link[ '3101' ] = '';
	$link[ '0202' ] = 'https://christus.fr/presentation-du-seigneur-au-temple-benoit-xvi';
	$link[ '0302' ] = '';
	$link[ '0402' ] = '';
	$link[ '0502' ] = '';
	$link[ '0602' ] = '';
	$link[ '0802' ] = '';
	$link[ '1002' ] = '';
	$link[ '1002' ] = '';
	$link[ '1402' ] = 'https://christus.fr/cyrille-et-methode';
	$link[ '1502' ] = '';
	$link[ '1702' ] = '';
	$link[ '1802' ] = 'https://christus.fr/bernadette-soubirous';
	$link[ '2102' ] = 'https://christus.fr/pierre-damien';
	$link[ '2202' ] = 'Chaire de S. Pierre, apôtre';
	$link[ '1002' ] = '';
	$link[ '0403' ] = '';
	$link[ '0703' ] = '';
	$link[ '0803' ] = '';
	$link[ '0903' ] = '';
	$link[ '1703' ] = 'https://christus.fr/lorica-de-saint-patrick';
	$link[ '1803' ] = 'https://christus.fr/cyrille-de-jerusalem';
	$link[ '1903' ] = 'https://christus.fr/saint-joseph';
	$link[ '2303' ] = '';
	$link[ '2503' ] = 'https://christus.fr/ne-tarde-plus-vierge-marie-donne-ta-reponse-bernard-de-clairvaux'; //voir conditions php plus loin...
	$link[ '0204' ] = '';
	$link[ '0404' ] = 'https://christus.fr/isidore-de-seville';
	$link[ '0504' ] = 'https://christus.fr/vincent-ferrier';
	$link[ '0704' ] = '';
	$link[ '1104' ] = '';
	$link[ '1304' ] = '';
	$link[ '2104' ] = 'https://christus.fr/anselme-de-canterbury';
	$link[ '2304' ] = '';
	$link[ '2404' ] = '';
	$link[ '2504' ] = '';
	$link[ '2804' ] = '';
	$link[ '2904' ] = 'https://christus.fr/catherine-de-sienne';
	$link[ '3004' ] = '';
	$link[ '0105' ] = 'https://christus.fr/saint-joseph';
	$link[ '0205' ] = 'https://christus.fr/athanase-d-alexandrie';
	$link[ '0305' ] = '';
	$link[ '0605' ] = '';
	$link[ '1205' ] = '';
	$link[ '1305' ] = '';
	$link[ '1405' ] = 'https://christus.fr/judas-iscariote-et-matthias';
	$link[ '1805' ] = '';
	$link[ '1905' ] = '';
	$link[ '2005' ] = 'https://christus.fr/bernardin-de-sienne';
	$link[ '2105' ] = '';
	$link[ '2205' ] = 'https://christus.fr/prieres-a-sainte-rita';
	$link[ '2505' ] = 'https://christus.fr/bede-le-venerable';
	$link[ '2605' ] = '';
	$link[ '2705' ] = 'https://christus.fr/augustin-de-canterbury';
	$link[ '3005' ] = 'https://christus.fr/jeanne-d-arc';
	$link[ '3105' ] = '';
	$link[ '0106' ] = 'https://christus.fr/justin-martyr';
	$link[ '0206' ] = '';
	$link[ '0306' ] = '';
	$link[ '0406' ] = '';
	$link[ '0506' ] = '';
	$link[ '0606' ] = '';
	$link[ '0906' ] = 'https://christus.fr/ephrem-le-syrien';
	$link[ '1106' ] = '';
	$link[ '1306' ] = 'https://christus.fr/antoine-de-padoue';
	$link[ '1906' ] = '';
	$link[ '2106' ] = '';
	$link[ '2206' ] = 'https://christus.fr/paulin-de-nole';
	$link[ '2406' ] = 'https://christus.fr/la-nativite-de-saint-jean-baptiste-joseph-marie-verlinde';
	$link[ '2606' ] = '';
	$link[ '2706' ] = 'https://christus.fr/cyrille-d-alexandrie';
	$link[ '2806' ] = 'https://christus.fr/irenee-de-lyon';
	$link[ '2906' ] = '';
	$link[ '3006' ] = '';
	$link[ '0307' ] = 'https://christus.fr/thomas-apotre';
	$link[ '0407' ] = '';
	$link[ '0507' ] = '';
	$link[ '0607' ] = 'https://christus.fr/maria-goretti';
	$link[ '0907' ] = '';
	$link[ '1007' ] = 'https://christus.fr/marcienne-de-dellys';
	$link[ '1107' ] = 'https://christus.fr/benoit-de-nursie';
	$link[ '1307' ] = '';
	$link[ '1407' ] = '';
	$link[ '1507' ] = 'https://christus.fr/bonaventure-de-bagnoregio';
	$link[ '1607' ] = '';
	$link[ '1707' ] = '';
	$link[ '2007' ] = 'https://christus.fr/apollinaire-de-ravenne';
	$link[ '2107' ] = 'https://christus.fr/laurent-de-brindisi';
	$link[ '2207' ] = 'https://christus.fr/marie-madeleine';
	$link[ '2307' ] = 'https://christus.fr/brigitte-de-suede';
	$link[ '2407' ] = '';
	$link[ '2507' ] = 'https://christus.fr/jacques-le-majeur';
	$link[ '2607' ] = 'https://christus.fr/saints-anne-et-joachim-jean-damascene';
	$link[ '2907' ] = '';
	$link[ '3007' ] = 'https://christus.fr/pierre-chrysologue';
	$link[ '3107' ] = 'https://christus.fr/ignace-de-loyola';
	$link[ '0108' ] = 'https://christus.fr/alphonse-de-liguori';
	$link[ '0208' ] = 'https://christus.fr/eusebe-de-verceil';
	$link[ '0408' ] = 'https://christus.fr/jean-baptiste-marie-vianney';
	$link[ '0508' ] = '';
	$link[ '0608' ] = 'https://christus.fr/sur-la-transfiguration-leon-le-grand';
	$link[ '0708' ] = '';
	$link[ '0808' ] = 'https://christus.fr/dominique-de-guzman';
	$link[ '0908' ] = '';
	$link[ '1008' ] = '';
	$link[ '1108' ] = 'https://christus.fr/claire-d-assise';
	$link[ '1208' ] = '';
	$link[ '1308' ] = '';
	$link[ '1408' ] = '';
	$link[ '1508' ] = 'https://christus.fr/tag/assomption';
	$link[ '1608' ] = 'https://christus.fr/etienne-de-hongrie';
	$link[ '1908' ] = 'https://christus.fr/jean-eudes';
	$link[ '2008' ] = 'https://christus.fr/bernard-de-clairvaux';
	$link[ '2108' ] = 'https://christus.fr/pie-x';
	$link[ '2208' ] = 'https://christus.fr/marie-reine-de-l-univers-jean-paul-ii';
	$link[ '2308' ] = '';
	$link[ '2408' ] = 'https://christus.fr/barthelemy-apotre';
	$link[ '2508' ] = 'https://christus.fr/louis-ix';
	$link[ '2608' ] = 'https://christus.fr/cesaire-d-arles';
	$link[ '2708' ] = '';
	$link[ '2808' ] = 'https://christus.fr/augustin-d-hippone';
	$link[ '2908' ] = 'https://christus.fr/l-exemple-de-jean-baptiste-pierre-chrysologue';
	$link[ '3008' ] = '';
	$link[ '0309' ] = 'https://christus.fr/gregoire-le-grand';
	$link[ '0809' ] = 'https://christus.fr/nativite-de-la-vierge-marie-joseph-marie-verlinde';
	$link[ '0909' ] = '';
	$link[ '1009' ] = '';
	$link[ '1209' ] = 'https://christus.fr/litaniae-lauretanae';
	$link[ '1309' ] = 'https://christus.fr/jean-chrysostome';
	$link[ '1409' ] = '';
	$link[ '1509' ] = '';
	$link[ '1609' ] = '';
	$link[ '1709' ] = 'https://christus.fr/robert-bellarmin';
	$link[ '1809' ] = '';
	$link[ '1909' ] = '';
	$link[ '2009' ] = '';
	$link[ '2109' ] = '';
	$link[ '2209' ] = '';
	$link[ '2509' ] = '';
	$link[ '2609' ] = '';
	$link[ '2709' ] = 'https://christus.fr/vincent-de-paul';
	$link[ '2809' ] = '';
	$link[ '2909' ] = '';
	$link[ '3009' ] = 'https://christus.fr/jerome-de-stridon';
	$link[ '0110' ] = 'https://christus.fr/therese-de-lisieux';
	$link[ '0210' ] = '';
	$link[ '0410' ] = 'https://christus.fr/francois-d-assise';
	$link[ '0610' ] = '';
	$link[ '0710' ] = '';
	$link[ '0910' ] = '';
	$link[ '1410' ] = '';
	$link[ '1510' ] = 'https://christus.fr/therese-de-jesus';
	$link[ '1610' ] = '';
	$link[ '1710' ] = '';
	$link[ '1810' ] = '';
	$link[ '1910' ] = '';
	$link[ '2310' ] = '';
	$link[ '2410' ] = '';
	$link[ '2510' ] = '';
	$link[ '2810' ] = '';
	$link[ '3010' ] = '';
	$link[ '0111' ] = 'https://christus.fr/tag/communion-des-saints';
	$link[ '0211' ] = 'Commémoration de tous les fidèles défunts';
	$link[ '0311' ] = 'https://christus.fr/martin-de-porres';
	$link[ '0411' ] = 'https://christus.fr/charles-borromee';
	$link[ '0711' ] = 'https://christus.fr/willibrord-d-utrecht';
	$link[ '0911' ] = '';
	$link[ '1011' ] = 'https://christus.fr/leon-le-grand';
	$link[ '1111' ] = 'https://christus.fr/martin-de-tours';
	$link[ '1211' ] = 'https://christus.fr/josaphat-de-polotsk';
	$link[ '1511' ] = 'https://christus.fr/albert-le-grand';
	$link[ '1611' ] = 'https://christus.fr/marguerite-de-hongrie';
	$link[ '1711' ] = 'https://christus.fr/elisabeth-de-hongrie';
	$link[ '1811' ] = '';
	$link[ '2111' ] = 'https://christus.fr/la-presentation-de-la-vierge-marie-au-temple-frere-elie';
	$link[ '2211' ] = 'https://christus.fr/cecile-de-rome';
	$link[ '2311' ] = 'https://christus.fr/clement-de-rome';
	$link[ '2411' ] = '';
	$link[ '2511' ] = 'https://christus.fr/catherine-d-alexandrie';
	$link[ '3011' ] = 'https://christus.fr/andre-le-protoclet';
	$link[ '0312' ] = 'https://christus.fr/francois-xavier';
	$link[ '0412' ] = 'https://christus.fr/jean-damascene';
	$link[ '0512' ] = 'https://christus.fr/crispine-de-thagare';
	$link[ '0612' ] = 'https://christus.fr/nicolas-de-myre';
	$link[ '0712' ] = 'https://christus.fr/ambroise-de-milan';
	$link[ '0812' ] = 'https://christus.fr/l-immaculee-conception-antonin-dalmace-sertillanges';
	$link[ '1112' ] = 'https://christus.fr/damase-i';
	$link[ '1312' ] = 'https://christus.fr/lucie-de-syracuse';
	$link[ '1412' ] = 'https://christus.fr/jean-de-la-croix';
	$link[ '1512' ] = 'https://christus.fr/pierre-canisius';
	$link[ '2312' ] = 'https://christus.fr/jean-de-kenty';
	$link[ '2512' ] = 'https://christus.fr/la-naissance-du-seigneur-maxime-de-turin';
	$link[ '2612' ] = 'https://christus.fr/etienne-le-protomartyr';
	$link[ '2712' ] = 'https://christus.fr/jean-l-evangeliste';
	$link[ '2812' ] = 'https://christus.fr/les-saints-innocents-pierre-chrysologue';
	$link[ '2912' ] = 'https://christus.fr/thomas-becket';
	$link[ '3112' ] = '';
	// Si pas de valeurs renseignées dans les tableaux :
	if ( empty( $item[ $calendar ] ) )
		$item[ $calendar ] = 'de la férie'; // Valeur par défaut
	if ( empty( $link[ $calendar ] ) )
		$link[ $calendar ] = '';
	$calendarLiturgy = '';
	if ( $html )
		$calendarLiturgy .= '<' . $html . '>';
	if ( $links AND $link[ $calendar ] != '' )
		$calendarLiturgy .= '<a href="' . $link[ $calendar ] . '">';
	$calendarLiturgy .= $item[ $calendar ];
	if ( $links AND $link[ $calendar ] != '' )
		$calendarLiturgy .= '</a>';
	if ( $html )
		$calendarLiturgy .= '</' . $html . '>' . PHP_EOL;
	return $calendarLiturgy;
}

//var_dump( ScripturaCalendarLiturgy( '0101', true, 'p' ) );exit;

