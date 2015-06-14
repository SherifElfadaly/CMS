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
		$page = \CMS::pages()->first('page_slug', $page);
		return view('crevisoft::' . $page->template, compact('page'));
	}
}
