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


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'Contao\ContentAliasExtended'   => 'system/modules/be_include_info/ContentAliasExtended.php',
    'Contao\ContentArticleExtended' => 'system/modules/be_include_info/ContentArticleExtended.php',
    'Contao\ContentModuleExtended'  => 'system/modules/be_include_info/ContentModuleExtended.php',
    'Contao\IncludeInfoHelper'      => 'system/modules/be_include_info/IncludeInfoHelper.php'
));

$cefile = 'system/modules/be_include_info/ContentElement_C34.php';
if( version_compare( VERSION, '3.3', '<' ) )
	$cefile = 'system/modules/be_include_info/ContentElement_C32.php';
if( version_compare( VERSION, '3.2', '<' ) )
	$cefile = 'system/modules/be_include_info/ContentElement_C31.php';
if( version_compare( VERSION, '3.1', '<' ) )
	$cefile = 'system/modules/be_include_info/ContentElement_C30.php';
ClassLoader::addClasses(array('Contao\ContentElement' => $cefile));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'be_include' => 'system/modules/be_include_info/templates'
));
