<?php namespace App\Http\Controllers;

class PagesController extends Controller {

	/**
	 * Render the given page.
	 * 
	 * @param  string $page
	 * @return Response
	 */
	public function showPage($page = 'home')
	{
		$page  = \CMS::pages()->first('page_slug', $page);
		$theme = \CMS::coreModules()->getActiveTheme()->module_key;
		return view($theme . '::' . $page->template, compact('page'));
	}
}
