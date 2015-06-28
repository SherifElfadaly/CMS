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