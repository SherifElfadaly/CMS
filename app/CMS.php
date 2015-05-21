<?php namespace App;

use App\AbstractRepositories\AbstractRepositoryContainer;

class CMS extends AbstractRepositoryContainer
{	
	/**
	 * Specify every module repositories name space.
	 * 
	 * @return array
	 */
	protected function getRepoNameSpace()
	{
		return [
		'App\Modules\Acl\Repositories',
		'App\Modules\Comment\Repositories',
		'App\Modules\Content\Repositories',
		'App\Modules\Gallery\Repositories',
		'App\Modules\Installation\Repositories',
		'App\Modules\Language\Repositories',
				];
	}
}