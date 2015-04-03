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
 * Front end content element "alias" with extended information.
 *
 * @author Fritz Michael Gschwantner <fmg@inspiredminds.at>
 */
class ContentAliasExtended extends \ContentAlias
{
    /**
     * Parse the template
     * @return string
     */
    public function generate()
    {
        if( TL_MODE == 'BE' )
        {
            // create new backend template
            $objTemplate = new \BackendTemplate('be_include');

            // get the element
            $objElement = \ContentModel::findByPk($this->cteAlias);
            if( $objElement === null ) return '';

            // get the parent article
            $objArticle = \ArticleModel::findByPk($objElement->pid);
            if( $objArticle === null ) return parent::generate();

            // get the parent pages
            $objPages = \PageModel::findParentsById($objArticle->pid);
            if( $objPages === null ) return parent::generate();

            // get the page titles
            $arrPageTitles = array_reverse( $objPages->fetchEach('title') );

            // set breadcrumb to original element
            $objTemplate->original = array
            (
                'crumbs' => implode( ' &raquo; ', $arrPageTitles ),
                'article' => array
                (
                    'title' => $objArticle->title,
                    'link' => 'contao/main.php?do=article&amp;table=tl_content&amp;id=' . $objArticle->id . '&amp;rt=' . REQUEST_TOKEN
                )
            );

            // get include breadcrumbs
            $includes = \IncludeInfoHelper::getIncludes( 'cteAlias', $this->cteAlias, $this->id );

            // set include breadcrumbs
            if( count( $includes ) > 1 )
                $objTemplate->includes = $includes;

            // add CSS
            $GLOBALS['TL_CSS'][] = \IncludeInfoHelper::BACKEND_CSS;

            // return info + content
            return $objTemplate->parse() . parent::generate();
        }

        // return content only
        return parent::generate();
    }
}
