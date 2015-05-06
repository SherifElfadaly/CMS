<?php namespace App\Http\Controllers;

abstract class BaseController extends Controller {
	
	/**
	 * The repository implementation.
	 *
	 * @var repository
	 */
	protected $repository;

	/**
	 * The modulePart implementation.
	 *
	 * @var modulePart
	 */
	protected $modulePart;

	/**
	 * The user permissions implementation.
	 *
	 * @var userPermissions
	 */
	protected $userPermissions;

	/**
	 * Create new BaseController instance.
	 * @param repository
	 * @param modulePart
	 */
	protected function __construct($repository, $modulePart)
	{
		$this->repository = $repository;
		$this->modulePart = $modulePart;
	}

	/**
	 * Throw exception if the user don't have the permission.
	 * @param permission
	 */
	protected function hasPermission($permission)
	{
		if ( ! \AclRepository::can($permission, $this->modulePart)) 
		{
			abort(403, 'Unauthorized');
		}
		return true;
	}
}
