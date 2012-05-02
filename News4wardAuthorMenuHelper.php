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

class News4wardAuthorMenuHelper extends System
{

	/**
	 * Return the WHERE-condition if a the url has an author-parameter
	 * @return bool|string
	 */
	public function authorFilter()
	{
		if(!$this->Input->get('author') || !preg_match("~^\d+$~",$this->Input->get('author'))) return;

		return 'author='.mysql_real_escape_string($this->Input->get('author'));
	}
}

?>