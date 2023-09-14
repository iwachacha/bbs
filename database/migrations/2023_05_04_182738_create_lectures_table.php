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
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lecture_id')->constrained();
            $table->string('title');
            $table->string('year');
            $table->float('fulfillment_rate', 2, 1); //講義充実度評価
            $table->float('ease_rate', 2, 1); //楽単度評価
            $table->float('satisfaction_rate', 2, 1); //満足度評価
            $table->text('lecture_content')->nullable();
            $table->text('good_point')->nullable();
            $table->text('bad_point')->nullable();
            $table->timestamps();
        });
        
        Schema::create('lecture_keeps', function (Blueprint $table) {
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
        
        //レビューのタグづけ
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        
        Schema::create('review_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained();
            $table->foreignId('tag_id')->constrained();
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
