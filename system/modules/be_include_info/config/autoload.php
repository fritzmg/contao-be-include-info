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
    'Contao\ContentArticleExtended' => 'system/modules/be_include_info/ContentArticleExtended.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'be_include' => 'system/modules/be_include_info/templates'
));