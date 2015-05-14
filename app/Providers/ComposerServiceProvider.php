<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function()
        {
            if (\Auth::check()) 
            {
                $isAdmin = \CMS::users()->userHasGroup(\Auth::user()->id, 'admin');
                view()->share('isAdmin', $isAdmin);
            }
        });
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        //
    }

}