<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const VIDEO_TYPE = 'video';
    public const PDF_TYPE = 'pdf';

    public const LESSONABLE_TYPE = [
        self::VIDEO_TYPE => 'App\Models\Video',
        self::PDF_TYPE => 'App\Models\Pdf'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function lessonable()
    {
        return $this->morphTo();
    }

    public function lessonUsers()
    {
        return $this->hasMany(LessonUser::class);
    }
}
