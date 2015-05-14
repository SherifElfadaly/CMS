<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
	'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		return parent::render($request, $e);
		
		if ($e->getMessage() == "Unauthorized") 
		{
			$message = 'You don\'t have permissions.';
			return response()->view('errors.error', compact('message'));
		}
		elseif($e instanceof \PDOException)
		{
			unlink(base_path('.env'));
			$errors = [
				'message' => [
				'Error with the DataBase please check your DataBase configs.'
				]
			];
			return redirect(url('Installation/setup'))->withErrors($errors);
		}
		elseif($e instanceof \ErrorException && strpos($e->getMessage(), 'Permission denied') && strpos($e->getMessage(), '.env'))
		{
			$errors = [
			'.env File Permission' => [
			'You need write permissions at the root folder to create the .env file for database conifg.'
			]
			];
			return \Redirect::back()->withInput()->withErrors($errors);
		}
		elseif($e instanceof \Illuminate\Session\TokenMismatchException) 
		{ 
			$errors = [
				'_token' => [
				'Please refresh the page'
				]
			];
			return \Redirect::back()->withInput(\Input::except('_token'))->withErrors($errors);
		}
		else
		{
			$message = 'Something went wrong.';
			return response()->view('errors.error', compact('message'));
		}
	}

}
