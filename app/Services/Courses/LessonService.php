<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Video;
use App\Models\Lesson;
use App\Enums\LessonType;
use Illuminate\Support\Facades\Storage;

class LessonService
{

    public function storeLesson(array $data): Lesson
    {
        //$video = Video::findOrFail($data['lessonable_id']);
        //$lesson = new Lesson();
        /*$lesson->name = $data['name'];
        $lesson->course_id = $data['course_id'];
        $lesson->section_id = $data['section_id'];
        //$video->lesson()->save($lesson);
        //$lesson->save();*/
        $lesson = Lesson::create([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'section_id' => $data['section_id'],
            'lessonable_id' => $data['lessonable_id'],
            'lessonable_type' => Lesson::LESSONABLE_TYPE[$data['lessonable_type']]
        ]);
        return $lesson;
    }

    public function getLessonById(int $id): string
    {
        $lesson = Lesson::findOrFail($id);
        return $lesson->lessonable->path;
    }

    public function updateLesson(array $data, int $id): void
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'section_id' => $data['section_id'],
            'lessonable_id' => $data['lessonable_id'],
            'lessonable_type' => Lesson::LESSONABLE_TYPE[$data['lessonable_type']]
        ]);
    }

    public function delete(int $id): void
    {
        $lesson = Lesson::findOrFail($id);
        $this->deleteDirectory("videos", $lesson->lessonable->path);
        $lesson->lessonable->delete();
        $lesson->delete();
    }

    private function deleteDirectory(string $disk, string $path)
    {
        $pathParts = pathinfo($path);
        Storage::disk($disk)->deleteDirectory($pathParts['dirname']);
    }
}
