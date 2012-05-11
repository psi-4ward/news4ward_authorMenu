<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * News4ward
 * a contentelement driven news/blog-system
 *
 * @author Christoph Wiechert <wio@psitrax.de>
 * @copyright 4ward.media GbR <http://www.4wardmedia.de>
 * @package news4ward_authorMenu
 * @filesource
 * @licence LGPL
 */

class ModuleNews4wardAuthorMenu extends News4ward
{
    /**
   	 * Template
   	 * @var string
   	 */
   	protected $strTemplate = 'mod_news4ward_authormenu';


    /**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### News4ward AuthorMenu ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$this->news_archives = $this->sortOutProtected(deserialize($this->news4ward_archives));

		// Return if there are no archives
		if (!is_array($this->news_archives) || count($this->news_archives) < 1)
		{
			return '';
		}

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
    {
		$objItems = $this->Database->prepare('	SELECT u.*
												FROM tl_news4ward_article AS a
												LEFT JOIN tl_user AS u ON (a.author=u.id)
												WHERE a.pid IN (?)
												GROUP BY u.id
												ORDER BY u.name')
						 ->execute(implode(',',$this->news_archives));

		if(!$objItems->numRows)
		{
			$this->Template->items = array();
			return;
		}

		// get jumpTo
		if($this->jumpTo)
		{
			$objJumpTo = $this->Database->prepare('SELECT id,alias FROM tl_page WHERE id=?')->execute($this->jumpTo);
			if(!$objJumpTo->numRows)
			{
				$objJumpTo = $GLOBALS['objPage'];
			}
		}
		else
		{
			$objJumpTo = $GLOBALS['objPage'];
		}

		$arr = array();
		while($objItems->next())
		{
			$arr[] = array(
				'item' => $objItems->name,
				'href' => $this->generateFrontendUrl($objJumpTo->row(),'/author/'.$objItems->id),
				'active' => ($this->Input->get('author') == $objItems->id)
			);

			// set active item for the active filter hinting
			if($this->Input->get('author') == $objItems->id)
			{
				if(!isset($GLOBALS['news4ward_filter_hint']))
				{
					$GLOBALS['news4ward_filter_hint'] = array();
				}

				$GLOBALS['news4ward_filter_hint']['author'] = array
				(
					'hint'  	=> $this->news4ward_filterHint,
					'value'		=> $objItems->name
				);

			}
		}

		$this->Template->items = $arr;
	}

}
?>