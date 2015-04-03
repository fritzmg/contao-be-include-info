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

    // returns array of include elements
    public static function getIncludes( $where, $includeId, $selfId = null )
    {
        // get all include elements
        $objElements = \ContentModel::findBy( $where, $includeId, array('order' => 'id'));

        // check for result
        if( $objElements === null )
            return array();

        // prepare include breadcrumbs
        $includes = array();

        // go throuch each include element
        while( $objElements->next() )
        {
            // get the parent article
            $objArticle = \ArticleModel::findByPk($objElements->pid);
            if( $objArticle === null ) continue;

            // get the parent pages
            $objPages = \PageModel::findParentsById($objArticle->pid);
            if( $objPages === null ) continue;    
  
            // get the page titles
            $arrPageTitles = array_reverse( $objPages->fetchEach('title') );

            // css classes for list
            $classes = array();
            if( $objElements->id == $selfId ) $classes[] = 'self';
            if( $objElements->invisible ) $classes[] = 'hidden';

            // create breadcrumb
            $includes[] = array
            (
                'crumbs' => implode( ' &raquo; ', $arrPageTitles ),
                'article' => array
                (
                    'title' => $objArticle->title,
                    'link' => 'contao/main.php?do=article&amp;table=tl_content&amp;id=' . $objArticle->id . '&amp;rt=' . REQUEST_TOKEN
                ),
                'class' => implode( ' ', $classes )
            );
        }

        // return the include elements
        return $includes;
    }
}
