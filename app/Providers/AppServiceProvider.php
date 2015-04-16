<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Module;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{	
		$modules = Module::all();
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
					'Permissions' =>[
						'All Permissions' => ['url' => url('/Acl/permissions'), 'icon'        => 'fa-eye'],
						'Add Permission'  => ['url' => url('/Acl/permissions/create'), 'icon' => 'fa-plus-circle'],
						'icon'            => 'fa fa-shield',
					],
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
		}
		view()->share('theme', \InstallationRepository::getActiveTheme());
		view()->share('sidebar', $sidebar);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
