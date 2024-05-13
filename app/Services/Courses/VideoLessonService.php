<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use App\Services\Courses\VideoService;
use App\Models\Video;

class VideoLessonService
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

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

    public function store(array $data)
    {
        $name = $this->videoService->uploadVideoBase64($data);
        $data['video'] = $name;

        \DB::beginTransaction();
        try {
            $video = Video::create([
                'path' => $name,
            ]);

            $lesson = Lesson::create([
                'name' => $data['name'],
                'course_id' => $data['course_id'],
                'section_id' => $data['section_id'],
                'lessonable_id' => $video->id,
                'lessonable_type' => Lesson::LESSONABLE_TYPE[Lesson::VIDEO_TYPE]
            ]);
            \DB::commit();
            return $lesson;
        } catch (Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data)
    {
        $lesson = Lesson::findOrFail($data['lesson_id']);
        $data['course_id'] = $lesson->course_id;
        if ($data['video']) {
            $name = $this->videoService->uploadVideoBase64($data);
            $oldVideo = public_path('videos/') . $lesson->lessonable->path;
            if (file_exists($oldVideo)) {
                @unlink($oldVideo);
            }
        } else {
            $name = $lesson->name;
        }
        \DB::beginTransaction();
        try {
            $lesson->update([
                'name' => $data['name'],
            ]);

            $video = Video::findOrFail($lesson->lessonable_id);
            $video->update([
                'path' => $name,
            ]);
            \DB::commit();
            return $lesson;
        } catch (Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function deleteLesson(int $id): void
    {
        $lesson = Lesson::findOrFail($id);
        $videoPath = public_path('videos/') . $lesson->lessonable->path;
        $lesson->lessonable->delete();
        $lesson->delete();

        if (file_exists($videoPath)) {
            @unlink($videoPath);
        }
    }

    public function getLessonsCount($courseId)
    {
        return Lesson::where('course_id', $courseId)->count();
    }
}
