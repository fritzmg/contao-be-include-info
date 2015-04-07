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


$GLOBALS['TL_DCA']['tl_article']['fields']['includeinfo'] = array( 'inputType' => 'includeInfo' );
$GLOBALS['TL_DCA']['tl_article']['config']['onload_callback'][] = array( 'IncludeInfoHelper', 'onloadArticle' );
