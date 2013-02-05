<?php

/**
 * News4ward
 * a contentelement driven news/blog-system
 *
 * @author Christoph Wiechert <wio@psitrax.de>
 * @copyright 4ward.media GbR <http://www.4wardmedia.de>
 * @package news4ward_archiveMenu
 * @filesource
 * @licence LGPL
 */


// Register the namespace
ClassLoader::addNamespace('Psi');

// Register the classes
ClassLoader::addClasses(array
(
	'Psi\News4ward\Module\AuthorMenu'   	=> 'system/modules/news4ward_authorMenu/Module/AuthorMenu.php',
	'Psi\News4ward\AuthorMenuHelper'   		=> 'system/modules/news4ward_authorMenu/AuthorMenuHelper.php',
));

// Register the templates
TemplateLoader::addFiles(array
(
	'mod_news4ward_authormenu' 				=> 'system/modules/news4ward_authorMenu/templates',
));
