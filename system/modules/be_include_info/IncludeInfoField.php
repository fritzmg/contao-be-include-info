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
 * Custom field for fetching the include info of a specific element
 */
class IncludeInfoField extends \Widget
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget_chk';


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		// create new include template
		$objTemplate = new \BackendTemplate('be_include');

		// get the active record
		$activeRecord = $this->arrConfiguration['activeRecord'];

		// get the type
		$type = $activeRecord->type;

		// get the table
		$table = $this->arrConfiguration['strTable'];

		// depending on type
		if( $type == 'alias' )
		{
			// get the element
            $objElement = \ContentModel::findByPk( $activeRecord->cteAlias );
            if( $objElement === null ) return '';

            // get the parent article
            $objArticle = \ArticleModel::findByPk( $objElement->pid );
            if( $objArticle === null ) return parent::generate();

            // get the parent pages
            $objPages = \PageModel::findParentsById( $objArticle->pid );
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
            $includes = \IncludeInfoHelper::getIncludes( 'cteAlias', $activeRecord->cteAlias, $activeRecord->id );

            // set include breadcrumbs
            if( count( $includes ) > 1 )
                $objTemplate->includes = $includes;
		}
		elseif( $type == 'article' )
		{
            // get the article
            $objArticle = \ArticleModel::findByPk( $activeRecord->articleAlias );
            if( $objArticle === null ) return parent::generate();

            // get the parent pages
            $objPages = \PageModel::findParentsById( $objArticle->pid );
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
            $includes = \IncludeInfoHelper::getIncludes( 'articleAlias', $activeRecord->articleAlias, $activeRecord->id );

            // set include breadcrumbs
            if( count( $includes ) > 1 )
                $objTemplate->includes = $includes;
		}
		elseif( $table == 'tl_content' )
		{
			// get include breadcrumbs that reference this content element
	        $includes = \IncludeInfoHelper::getIncludes( array("cteAlias = ? AND type = 'alias'"), array( $activeRecord->id ) );

	        // set include breadcrumbs
            if( count( $includes ) > 0 )
                $objTemplate->includes = $includes;
	    }
		elseif( $table == 'tl_article' )
		{
			// get include breadcrumbs that reference this article
	        $includes = \IncludeInfoHelper::getIncludes( array("articleAlias = ? AND type = 'article'"), array( $activeRecord->id ) );

	        // set include breadcrumbs
            if( count( $includes ) > 0 )
                $objTemplate->includes = $includes;
		}

		// check for includes and add CSS
		if( $objTemplate->includes )
			$GLOBALS['TL_CSS'][] = \IncludeInfoHelper::BACKEND_CSS;

		// return template
		return $objTemplate->parse();
	}
}
