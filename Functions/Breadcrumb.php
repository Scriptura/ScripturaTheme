<?php

// -----------------------------------------------------------------------------
// @section     Breadcrumb
// @description Fil d'Ariane
// -----------------------------------------------------------------------------

function ScripturaBreadcrumb()
{
	global $singleCatLink;
	global $singleCatName;
	global $siteUri;
	global $slug;
	global $name;
	//global $category;

	if( count($slug) == 1 AND $slug[0] == 'Login' ) :
	$name = 'Login';
	endif;
	if( count($slug) == 1 AND $slug[0] == 'Register' ) :
	$name = 'Register';
	endif;
	if( count($slug) == 1 AND $slug[0] == 'Profil' ) :
	$name = 'Profil';
	endif;

	$breadcrumb = '<nav class="breadcrumb">' . PHP_EOL;
	$breadcrumb .= '<div class="wrap">' . PHP_EOL;
	$breadcrumb .= '<ul itemprop="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">' . PHP_EOL;
	$breadcrumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . $siteUri . '" itemprop="item"><span itemprop="name">' . __('Home', 'scriptura') . '</span></a></li>' . PHP_EOL;
	if ( is_single() ) :
		$breadcrumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . $singleCatLink . '" itemprop="item"><span itemprop="name">' . $singleCatName . '</span></a></li>' . PHP_EOL;
	endif;
	$breadcrumb .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="/Pages/Article.html" itemprop="item"><span itemprop="name">' . $name . '</span></a></li>' . PHP_EOL;
	$breadcrumb .= '</ul>' . PHP_EOL;
	$breadcrumb .= '</div>' . PHP_EOL;
	$breadcrumb .= '</nav>' . PHP_EOL;
	return $breadcrumb;
}

$breadcrumb .= ScripturaBreadcrumb();
