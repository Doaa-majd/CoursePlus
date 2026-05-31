<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Lesson;
use App\Models\Video;
use App\Models\Pdf;
use Illuminate\Support\Str;

class PdfLessonService
{

    public function store($data)
    {
        $fileData = $this->uploadFile($data);
        \DB::beginTransaction();
        try {
            $pdf = Pdf::create([
                'path' => $fileData['path'],
            ]);

            $lesson = Lesson::create([
                'name' => $data['name'],
                'course_id' => $data['course_id'],
                'section_id' => $data['section_id'],
                'lessonable_id' => $pdf->id,
                'lessonable_type' => Lesson::LESSONABLE_TYPE[Lesson::PDF_TYPE]
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
        if ($data['pdf_file']) {
            $fileData = $this->uploadFile($data);
            $name = $fileData['name'];
            $pdfFile = public_path('pdfs/') . $lesson->lessonable->path;
            if (file_exists($pdfFile)) {
                @unlink($pdfFile);
            }
        } else {
            $name = $lesson->name;
        }

        \DB::beginTransaction();
        try {
            $lesson->update([
                'name' => $data['name'],
            ]);

            $pdf = Pdf::findOrFail($lesson->lessonable_id);
            $pdf->update([
                'path' => $name,
            ]);
            \DB::commit();
            return $lesson;
        } catch (Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function uploadFile($data)
    {
        $file = $data['pdf_file'];
        $storeAs = 'courses' . '/' . $data['course_id'];
        $fileName = ((string) Str::uuid()) . '.' . $file->extension();
        $path =  $file->storeAs($storeAs, $fileName, 'pdf');

        return [
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'extension' => $file->extension()
        ];
    }
    public function uploadPdfBase64(array $data)
    {
        $name = 'Course-' . $data['course_id'] . '-' . $data['name'] . '.' .
             explode('/', explode(':', substr($data['pdf64'], 0, strpos($data['pdf64'], ';')))[1])[1];
        $pdf64Data = substr($data['pdf64'], strpos($data['pdf64'], ',') + 1);

        $pdf64Data = base64_decode($pdf64Data);
        \Storage::disk('attachement')->put($name, $pdf64Data);
        return $name;
    }

    public function delete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $pdfPath = public_path('pdfs/') . $lesson->lessonable->path;
        $lesson->lessonable->delete();
        $lesson->delete();
        if (file_exists($pdfPath)) {
            @unlink($pdfPath);
        }
    }
}
