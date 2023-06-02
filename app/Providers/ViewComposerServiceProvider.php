<?php

namespace App\Providers;

use App\View\Composers\LectureComposer;
use App\View\Composers\ReviewComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer( ['lectures/index', 'lectures/create', 'lectures/edit', 'profile.edit', 'auth.register'], LectureComposer::class );
        View::composer( ['reviews/create', 'reviews/edit'], ReviewComposer::class );
    }
}