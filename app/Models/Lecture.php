<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecture extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    
    public function lecture_category() {
        return $this->belongsTo(LectureCategory::class);
    }
    
    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
    
    public function course() {
        return $this->belongsTo(Course::class);
    }
    
    public function lecture_keeps() {
        return $this->hasMany(LectureKeep::class);  
    }
    
    protected $fillable = [
        'user_id', 'lecture_category_id', 'faculty_id', 'department_id', 'course_id', 
        'lecture_name', 'professor_name', 'season', 'grade'
    ];
    
    public function search_lectures($request){
        
        //講義検索処理　複数条件で絞り込みしていき、最終的に残ったものを取得する　
        
        $lectures = $this;
        
        //講義名検索
        $search_lecture_name = $request->input('search_lecture_name'); 
        if( !(empty($search_lecture_name)) ){
            $lectures = $lectures->where('lecture_name', 'LIKE', '%'.$search_lecture_name.'%');
        } else {
            
        }
        
        //教員名検索
        $search_professor_name = $request->input('search_professor_name'); 
        if( !(empty($search_professor_name)) ){
            $lectures = $lectures->where('professor_name', 'LIKE', '%'.$search_professor_name.'%');
        } else {
            
        }
        
        //講義カテゴリー検索
        $search_category = $request->input('search_category');
        if( !(empty($search_category)) ){
            $lectures = $lectures->where('lecture_category_id', $search_category);
        } else {
            
        }
        
        //学部検索
        $search_faculty = $request->input('search_faculty');
        if( !(empty($search_faculty)) ){
            $lectures = $lectures->where('faculty_id', $search_faculty);
        } else {
            
        }
        
        //学科検索
        $search_department = $request->input('search_department');
        if( !(empty($search_department)) ){
            $lectures = $lectures->where('department_id', $search_department);
        } else {
            
        }
        
        //コース検索
        $search_course = $request->input('search_course');
        if( !(empty($search_course)) ){
            $lectures = $lectures->where('course_id', $search_course);
        } else {
            
        }
        
        $result_count = $lectures->count(); //検索取得件数
        $lectures = $lectures->withcount('reviews')->orderBy('created_at', 'desc')->paginate(5); //検索結果の講義情報をレビューの数と合わせて新着順で取得
        
        return [$result_count, $lectures];
        
    }
}
