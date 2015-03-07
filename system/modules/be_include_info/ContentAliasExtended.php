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

			// get the parent article
			$objArticle = \ArticleModel::findByPk($this->pid);

			// get the parent pages
			$objPages = \PageModel::findParentsById($objArticle->pid);

			// get the page titles
			$arrPageTitles = array_reverse( $objPages->fetchEach('title') );

			// get all include elements
			$objElements = \ContentModel::findBy('cteAlias', $this->cteAlias, array('order' => 'id'));

			// set breadcrumb to original element
			$objTemplate->original = implode( ' &raquo; ', $arrPageTitles );

			// set edit url
			$objTemplate->editurl = 'contao/main.php?do=article&amp;table=tl_content&amp;act=edit&amp;id=' . $this->cteAlias;

			// prepare include breadcrumbs
			$includes = array();

			// go throuch each include element
			while( $objElements->next() )
			{
				// get the parent article
				$objArticle = \ArticleModel::findByPk($objElements->pid);

				// get the parent pages
				$objPages = \PageModel::findParentsById($objArticle->pid);	
				
				// get the page titles
				$arrPageTitles = array_reverse( $objPages->fetchEach('title') );

				// create breadcrumb
				$includes[] = ( $objElements->id == $this->id ? '<b>' : '' ) . implode( ' &raquo; ', $arrPageTitles ) . ( $objElements->id == $this->id ? '</b>' : '' );
			}

			// set include breadcrumbs
			$objTemplate->includes = $includes;

			// return info + content
			return $objTemplate->parse() . parent::generate();
		}

		// return content only
		return parent::generate();
	}
}
