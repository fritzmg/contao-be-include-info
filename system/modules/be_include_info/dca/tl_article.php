<?php

/**
 * Contao Open Source CMS
 *
 * Extension to extend the ContentAlias and ContentArticle content elements to show more info in the backend
 * 
 * @copyright inspiredminds 2015
 * @package   be_include_info
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   GPL-2.0
 */


foreach( $GLOBALS['TL_DCA']['tl_article']['palettes'] as &$palette )
	if( is_string( $palette ) )
		$palette.= ';{includeinfo_legend:hide},includeinfo';

$GLOBALS['TL_DCA']['tl_article']['fields']['includeinfo'] = array( 'inputType' => 'includeInfo' );
