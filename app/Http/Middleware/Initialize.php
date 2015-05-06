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
		   (\InstallationRepository::scanModules() === true &&  \AclRepository::checkForAdmins() == 0))
		{ 
			if ($request->path() !== 'Installation/setup' && 
				$request->path() !== 'Installation/setup/saveadmin')
			{
				redirect(url('Installation/setup'))->send();
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
						'All Users' => ['url' => url('/Acl/users'), 'icon'        => 'fa-eye'],
						'Add User'  => ['url' => url('/Acl/users/create'), 'icon' => 'fa-plus-circle'],
						'icon'      => 'fa-user',
					],
					'Groups'      => [
						'All Groups' => ['url' => url('/Acl/groups'), 'icon'        => 'fa-eye'],
						'Add Group'  => ['url' => url('/Acl/groups/create'), 'icon' => 'fa-plus-circle'],
						'icon'       => 'fa-users',
					],
					/*'Permissions' =>[
					'All Permissions' => ['url' => url('/Acl/permissions'), 'icon'        => 'fa-eye'],
					'Add Permission'  => ['url' => url('/Acl/permissions/create'), 'icon' => 'fa-plus-circle'],
					'icon'            => 'fa fa-shield',
					],*/
					];
				}
				elseif ($module['slug'] == 'language') 
				{
					$sidebar[] = [
					'Languages' => [
					'All Languages' => ['url' => url('/language/'), 'icon'       => 'fa-eye'],
					'Add Language'  => ['url' => url('/language/create'), 'icon' => 'fa-plus-circle'],
					'icon'          => 'fa-wrench',
					],
					];
				}
				elseif ($module['slug'] == 'installation') 
				{
					$sidebar[] = [
					'Installation' => [
					'All Modules' => ['url' => url('/Installation'), 'icon'        => 'fa-eye'],
					'Add Modules' => ['url' => url('/Installation/create'), 'icon' => 'fa-plus-circle'],
					'icon'        => 'fa-wrench',
					],
					];
				}
				elseif ($module['slug'] == 'content') 
				{
					$sidebar[] = [
					'Contents' => [
					'All Contents' => ['url' => url('/content/'), 'icon'       => 'fa-eye'],
					'Add Content'  => ['url' => url('/content/create'), 'icon' => 'fa-plus-circle'],
					'icon'         => 'fa-pencil-square',
					],
					'Tags'     => [
					'All Tags' => ['url' => url('/content/tags/'), 'icon'       => 'fa-eye'],
					'Add Tag'  => ['url' => url('/content/tags/create'), 'icon' => 'fa-plus-circle'],
					'icon'     => 'fa-tags',
					],
					'Sections' => [
					'All Sections Types' => ['url' => url('/content/sectiontypes/'), 'icon'       => 'fa-eye'],
					'Add Section Types'  => ['url' => url('/content/sectiontypes/create'), 'icon' => 'fa-plus-circle'],
					'All Sections'       => ['url' => url('/content/sections/'), 'icon'           => 'fa-eye'],
					'Add Section'        => ['url' => url('/content/sections/create'), 'icon'     => 'fa-plus-circle'],
					'icon'               => 'fa-bars',
					],
					];
				}
				elseif ($module['slug'] == 'gallery') 
				{
					$sidebar[] = [
					'Galleries'  => [
					'All Galleries' => ['url' => url('/gallery/'), 'icon' => 'fa-eye'],
					'icon'          => 'fa fa-camera',
					],
					'Albums'     => [
					'All Albums' => ['url' => url('/gallery/album/'), 'icon'       => 'fa-eye'],
					'Add Album'  => ['url' => url('/gallery/album/create'), 'icon' => 'fa-plus-circle'],
					'icon'       => 'fa-picture-o',
					],
					];
				}
				elseif ($module['slug'] == 'comment') 
				{
					$sidebar[] = [
					'Comments'  => [
					'All Comments' => ['url' => url('/comment/'), 'icon' => 'fa-comments'],
					'icon'          => 'fa fa-comments',
					]
					];
				}
			}

			$categories = \ContentRepository::getSectionTree(url(\InstallationRepository::getActiveTheme()->module_key . '/category/'));
			$languages  = \LanguageRepository::getAllLanguages();

			view()->share('theme', \InstallationRepository::getActiveTheme());
			view()->share('sidebar', $sidebar);
			view()->share('categories', $categories);
			view()->share('languages', $languages);

			//Set the site language
			\Lang::setlocale(\Session::get('language', \Lang::locale()));
		}

		return $next($request);
	}

}
