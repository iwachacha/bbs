<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \URL::forceScheme('https');
        $this->app['request']->server->set('HTTPS','on');
        
        $class_methods = [
            '対面',
            'オンデマンド',
            'ZOOM',
            'その他'
        ];
        $attedances = [
            '直接出席確認',
            '課題提出で出席確認',
            'コース閲覧で出席確認',
            '出席確認しない',
            'その他'
        ];
        $evaluation_methods = [
            'テスト',
            'レポート',
            'テストとレポート',
            '出席のみ',
            'その他'
        ];
        $levels = [
            '非常に難しい',
            '難しい',
            '普通',
            '易しい',
            '非常に易しい'
        ];
        $syllabi = [
            'シラバス通りだった',
            'シラバスと少しズレていた',
            'シラバスと大きくズレていた'
        ];
        $date = new Carbon('now');
        $year = $date->year;
        
        view()->share('class_methods', $class_methods);
        view()->share('attedances', $attedances);
        view()->share('evaluation_methods', $evaluation_methods);
        view()->share('levels', $levels);
        view()->share('syllabi', $syllabi);
        view()->share('year', $year);
    }
}
