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
            $table->integer('year');
            $table->string('class_method');
            $table->string('attedance');
            $table->string('evaluation_method');
            $table->string('evaluation_level');
            $table->string('lecture_level');
            $table->string('comp_syllabus');
            $table->string('title');
            $table->text('lecture_content')->nullable();
            $table->text('body')->nullable();
            $table->integer('rate_credit'); //単位取得難易度評価
            $table->integer('rate_adequacy'); //講義充実度評価
            $table->integer('rate_satisfaction'); //総合満足度評価
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('lecture_keeps', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lecture_id')->constrained();
        });

        Schema::create('review_goods', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('review_id')->constrained();
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
            $table->text('body');
            $table->string('price');
            $table->integer('rate_taste'); //味評価
            $table->integer('rate_cost'); //コスパ評価
            $table->integer('rate_atmosphere'); //雰囲気評価
            $table->integer('rate_satisfaction'); //総合満足度評価
        });
        
        Schema::create('gourmet_keeps', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gourmet_id')->constrained();
        });

        Schema::create('gourmet_goods', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gourmet_id')->constrained();
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
        
        Schema::create('topic_keeps', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('topic_id')->constrained();
        });

        Schema::create('post_goods', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('post_id')->constrained();
        });
    
        //カラム追加
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('faculty_id')->nullable()->constrained();
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('course_id')->nullable()->constrained();
            $table->integer('grade')->nullable();
        });
    }
    
    public function down()
    {
        //
    }
};
