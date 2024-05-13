<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Video;
use App\Models\Lesson;
use Illuminate\Support\Str;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Support\Facades\Storage;

class VideoService
{

    public function storeVideo(array $data): Video
    {
        $videoData = $this->uploadVideo($data);
        $video = Video::create(['path' => $videoData['path']]);
        ConvertVideoForStreaming::dispatch($video);
        return $video;
    }

    private function uploadVideo(array $data): array
    {
        $file = $data['path'];
        $storeAs = 'courses' . '/' . $data['course_id'];
        $fileName = ((string) Str::uuid()) . '.' . $data['path']->extension();
        $path =  $data['path']->storeAs($storeAs, $fileName, 'videos-temp');

        return [
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $file->extension(),
        ];
    }

    public function updateVideo(array $data, int $videoId): void
    {
        $video = Video::findOrFail($videoId);
        $this->deleteDirectory("videos", $video->path);

        $videoData = $this->uploadVideo($data);
        $video->update(['path' => $videoData['path']]);
        ConvertVideoForStreaming::dispatch($video);
    }

    public function delete(int $videoId): void
    {
        $video = Video::findOrFail($videoId);
        //delete from disk
        $this->deleteDirectory("videos", $video->path);
        //Update the lesson if the lesson saved with the video id
        $lesson = $video->lesson;
        if ($lesson) {
            $lesson->update([
                'lessonable_id' => null,
                'lessonable_type' => null
            ]);
        }
        //delete from video table
        $video->delete();
    }

    private function deleteDirectory(string $disk, string $path)
    {
        $pathParts = pathinfo($path);
        Storage::disk($disk)->deleteDirectory($pathParts['dirname']);
    }

    public function uploadVideoBase64(array $data)
    {
        if (preg_match('/^data:video\/(\w+);base64,/', $data['video'])) { //check if type video
            $name = 'Course-' . $data['course_id'] . '-' . $data['name'] . '.' . explode('/', explode(':', substr($data['video'], 0, strpos($data['video'], ';')))[1])[1];
            $videoData = substr($data['video'], strpos($data['video'], ',') + 1);

            $videoData = base64_decode($videoData);
            \Storage::disk('videos')->put($name, $videoData);
        }
        return $name;
    }
}
