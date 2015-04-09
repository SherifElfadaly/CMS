<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

	'facebook' => [
		'client_id'     => '410095522487067',
		'client_secret' => '0cf9d9c318b4c16d666d5841f0cbf048',
		'redirect'      => 'http://localhost/laramodules/public/Acl/social/facebook',
	],
	'twitter' => [
		'client_id'     => 'your-github-app-id',
		'client_secret' => 'your-github-app-secret',
		'redirect'      => 'http://your-callback-url',
	],

	'github' => [
		'client_id'     => 'your-github-app-id',
		'client_secret' => 'your-github-app-secret',
		'redirect'      => 'http://your-callback-url',
	],

];
