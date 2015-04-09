<?php
namespace App\Modules\Menu\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
	/**
	 * Register the Menu module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Menu\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Menu module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('menu', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('menu', realpath(__DIR__.'/../Resources/Views'));
	}
}
