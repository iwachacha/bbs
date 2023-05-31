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
            $table->string('name', 50);
            $table->string('professor_last', 50);
            $table->string('professor_first', 50);
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
            $table->text('lecture_content');
            $table->string('title', 50);
            $table->text('body');
            $table->integer('rate_credit');//単位取得難易度評価
            $table->integer('rate_adequacy');//講義充実度評価
            $table->integer('rate_satisfaction');//総合満足度評価
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('review_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('review_id')->constrained();
            $table->string('title', 50)->nullable();
            $table->text('body');
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
            $table->string('body');
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
        Schema::dropIfExists('lecture_categories');
        Schema::dropIfExists('faculties');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('lectures');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('review_questions');
        Schema::dropIfExists('lecture_keeps');
        Schema::dropIfExists('review_goods');
        Schema::dropIfExists('club_types');
        Schema::dropIfExists('club_kinds');
        Schema::dropIfExists('clubs');
        Schema::dropIfExists('club_questions');
        Schema::dropIfExists('club_keeps');
        Schema::dropIfExists('topic_categories');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('topic_keeps');
        Schema::dropIfExists('post_goods');
        Schema::dropIfExists('users');
    }
};
