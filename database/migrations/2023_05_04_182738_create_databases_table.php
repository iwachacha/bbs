<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        //講義評価
        Schema::create('lecture_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained();
            $table->string('name');
        });
        
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained();
            $table->string('name');
        });
        
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lecture_category_id')->constrained();
            $table->foreignId('faculty_id')->nullable()->constrained();
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->string('lecture_name');
            $table->string('professor_name');
            $table->string('season');
            $table->integer('grade');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lecture_id')->constrained();
            $table->integer('year')->nullable();
            $table->string('class_method')->nullable();
            $table->string('attedance')->nullable();
            $table->string('evaluation_method')->nullable();
            $table->string('evaluation_level')->nullable();
            $table->string('lecture_level')->nullable();
            $table->string('comp_syllabus')->nullable();
            $table->string('title');
            $table->text('lecture_content')->nullable();
            $table->text('body')->nullable();
            $table->integer('rate_credit'); //単位取得難易度評価
            $table->integer('rate_adequacy'); //講義充実度評価
            $table->integer('rate_satisfaction'); //総合満足度評価
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('lecture_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lecture_id')->constrained();
            $table->timestamps();
        });

        Schema::create('review_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('review_id')->constrained();
            $table->timestamps();
        });
        
        //グルメ情報
        Schema::create('gourmet_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        Schema::create('gourmet_scenes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        Schema::create('gourmets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gourmet_category_id')->constrained();
            $table->foreignId('gourmet_scene_id')->constrained();
            $table->string('name');
            $table->string('address');
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('price');
            $table->text('image')->nullable();
            $table->integer('rate_taste'); //味評価
            $table->integer('rate_cost'); //コスパ評価
            $table->integer('rate_atmosphere'); //雰囲気評価
            $table->integer('rate_satisfaction'); //総合満足度評価
        });
        
        Schema::create('gourmet_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gourmet_id')->constrained();
            $table->timestamps();
        });
        
        //悩み相談
        Schema::create('problem_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('problem_category_id')->constrained();
            $table->boolean('solve'); //お悩みが解決したかどうか判定
            $table->string('title');
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('problem_id')->constrained();
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('ploblem_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('problem_id')->constrained();
            $table->timestamps();
        });

        Schema::create('solutions_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('solution_id')->constrained();
            $table->timestamps();
        });
        
        //雑談
        Schema::create('topic_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('topic_category_id')->constrained();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('topic_id')->constrained();
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('topic_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('topic_id')->constrained();
            $table->timestamps();
        });

        Schema::create('post_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('post_id')->constrained();
            $table->timestamps();
        });
        
        //フォロー機能
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_user_id')->constrained('users');
            $table->foreignId('followee_user_id')->constrained('users');
            $table->timestamps();
        });
        
        //usersカラム追加
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('faculty_id')->nullable()->constrained();
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->integer('grade')->nullable();
            $table->text('comment')->nullable();
        });
    }
    
    public function down()
    {
        //
    }
};
