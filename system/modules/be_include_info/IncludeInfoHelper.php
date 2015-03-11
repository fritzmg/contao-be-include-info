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

namespace Contao;


/**
 * Helper Class
 *
 * @author Fritz Michael Gschwantner <fmg@inspiredminds.at>
 */
class IncludeInfoHelper extends \Backend
{
    // path to backend CSS file
    const BACKEND_CSS = 'system/modules/be_include_info/assets/be_styles.css';

    /**
     * Parse the template
     * @return string
     */
    public static function addBackendCSS()
    {
        if( !is_array( $GLOBALS['TL_CSS'] ) )
            $GLOBALS['TL_CSS'] = array();

        if( !in_array( self::BACKEND_CSS, $GLOBALS['TL_CSS'] ) )
            $GLOBALS['TL_CSS'][] = self::BACKEND_CSS;
    }
}
