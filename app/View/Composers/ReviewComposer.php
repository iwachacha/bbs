<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Carbon\Carbon;

class ReviewComposer
{
    public function compose(View $view){
        
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
        $now_year = $date->year;
        
        $view->with([
            'class_methods' => $class_methods,
            'attedances' => $attedances,
            'evaluation_methods' => $evaluation_methods,
            'levels' => $levels,
            'syllabi' => $syllabi,
            'now_year' => $now_year
        ]);
  }
}