<?php namespace App\Http\Controllers;

abstract class BaseController extends Controller {

	/**
	 * The modulePart implementation.
	 * 
	 * @var modulePart
	 */
	protected $modulePart;

	/**
	 * Create new BaseController instance.
	 * 
	 * @param moduleParts
	 */
	protected function __construct($modulePart)
	{
		$this->middleware('AclAuthenticate');
		$this->modulePart = $modulePart;
		$this->checkAdmin();
	}

	/**
	 * Check if the admin only is set to true then allow 
	 * for admin users only else check the given permissions.
	 * 
	 * @param permission
	 */
	private function checkAdmin()
	{	
		$adminOnly = property_exists($this, 'adminOnly') ? $this->adminOnly : false;
		if ($adminOnly) 
		{
			$this->middleware('AclAdminAuthenticate');
		}
		else
		{
			$this->checkPermission();
		}
	}

	/**
	 * Return a list of route actions with permissions.
	 * 
	 * @param permission
	 */
	private function getRouteActionPermissions()
	{	
		$extraPermissions = property_exists($this, 'permissions') ? $this->permissions : array();

		return array_merge([
			'Index'  => 'show', 
			'Create' => 'add', 
			'Edit'   => 'edit', 
			'Delete' => 'delete'
			], $extraPermissions);
	}	

	/**
	 * Check the permissions passed on the called route action.
	 * 
	 * @param permission
	 */
	private function checkPermission()
	{
		foreach ($this->getRouteActionPermissions() as $routeAction => $permission) 
		{
			if (strpos(explode('@', \Route::currentRouteAction())[1], $routeAction))
			{
				$this->hasPermission($permission);
			}
		}
	}

	/**
	 * Throw exception if the user don't have the permission.
	 * 
	 * @param permission
	 */
	protected function hasPermission($permission)
	{
		if ( ! \CMS::permissions()->can($permission, $this->modulePart)) 
		{
			abort(403, 'Unauthorized');
		}
		return true;
	}
}
