<?php namespace App\Http\Middleware;

use Closure;

class Initialize {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if( ! is_writable(base_path('storage')))
		{
			return response('Storage folder need write permissions.');
		}
		if ( ! file_exists(base_path('.env')) || 
		   (\CMS::coreModules()->scanModules() === true &&  \CMS::groups()->adminCount() == 0))
		{ 
			if ($request->path() !== 'admin/Installation/setup' && 
				$request->path() !== 'admin/Installation/setup/saveadmin')
			{
				redirect(url('admin/Installation/setup'))->send();
			}
		}
		else
		{		
			$modules = \Module::all();
			$sidebar = array();
			foreach ($modules as $module) 
			{
				if ($module['slug'] == 'acl') 
				{
					$sidebar[] = [
					'Users'       =>[
						'All Users' => ['url' => url('admin/Acl/users'), 'icon'        => 'fa-eye'],
						'Add User'  => ['url' => url('admin/Acl/users/create'), 'icon' => 'fa-plus-circle'],
						'icon'      => 'fa-user',
					],
					'Groups'      => [
						'All Groups' => ['url' => url('admin/Acl/groups'), 'icon'        => 'fa-eye'],
						'Add Group'  => ['url' => url('admin/Acl/groups/create'), 'icon' => 'fa-plus-circle'],
						'icon'       => 'fa-users',
					]
					];
				}
				elseif ($module['slug'] == 'language') 
				{
					$sidebar[] = [
					'Languages' => [
					'All Languages' => ['url' => url('admin/language/'), 'icon'       => 'fa-eye'],
					'Add Language'  => ['url' => url('admin/language/create'), 'icon' => 'fa-plus-circle'],
					'icon'          => 'fa-wrench',
					],
					];
				}
				elseif ($module['slug'] == 'installation') 
				{
					$sidebar[] = [
					'Installation' => [
					'All Modules' => ['url' => url('admin/Installation'), 'icon'        => 'fa-eye'],
					'Add Modules' => ['url' => url('admin/Installation/create'), 'icon' => 'fa-plus-circle'],
					'icon'        => 'fa-wrench',
					],
					];
				}
				elseif ($module['slug'] == 'content') 
				{
					$sidebar[] = [
					'Contents' => [
					'All Contents Types' => ['url' => url('admin/content/contenttypes/'), 'icon'       => 'fa-eye'],
					'Add Content Type'  => ['url' => url('admin/content/contenttypes/create'), 'icon' => 'fa-plus-circle'],
					'icon'         => 'fa-pencil-square',
					],
					'Tags'     => [
					'All Tags' => ['url' => url('admin/content/tags/'), 'icon'       => 'fa-eye'],
					'Add Tag'  => ['url' => url('admin/content/tags/create'), 'icon' => 'fa-plus-circle'],
					'icon'     => 'fa-tags',
					],
					'Sections' => [
					'All Sections Types' => ['url' => url('admin/content/sectiontypes/'), 'icon'       => 'fa-eye'],
					'Add Section Types'  => ['url' => url('admin/content/sectiontypes/create'), 'icon' => 'fa-plus-circle'],
					'icon'               => 'fa-bars',
					],
					];
				}
				elseif ($module['slug'] == 'gallery') 
				{
					$sidebar[] = [
					'Galleries'  => [
					'All Galleries' => ['url' => url('admin/gallery/'), 'icon' => 'fa-eye'],
					'icon'          => 'fa fa-camera',
					],
					'Albums'     => [
					'All Albums' => ['url' => url('admin/gallery/album/'), 'icon'       => 'fa-eye'],
					'Add Album'  => ['url' => url('admin/gallery/album/create'), 'icon' => 'fa-plus-circle'],
					'icon'       => 'fa-picture-o',
					],
					];
				}
				elseif ($module['slug'] == 'comment') 
				{
					$sidebar[] = [
					'Comments'  => [
					'All Comments' => ['url' => url('admin/comment/'), 'icon' => 'fa-comments'],
					'icon'          => 'fa fa-comments',
					]
					];
				}
			}

			$categories = \CMS::sections()->getSectionTree();
			$languages  = \CMS::languages()->all();
			
			view()->share('sidebar', $sidebar);
			view()->share('categories', $categories);
			view()->share('languages', $languages);

			//Set the site language
			\Lang::setlocale(\Session::get('language', \Lang::locale()));
		}

		return $next($request);
	}

}
