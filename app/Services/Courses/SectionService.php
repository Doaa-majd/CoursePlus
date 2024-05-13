<?php

declare(strict_types=1);

namespace App\Services\Courses;

use App\Models\Section;
use Illuminate\Database\Eloquent\Collection;

class SectionService
{
    public function store(array $data): Section
    {
        return Section::Create([
            'course_id' => $data['course_id'],
            'name' => $data['name']
        ]);
    }

    public function update(array $data, int $id): void
    {
        $section = Section::FindOrFail($id);
        $section->update([
            'course_id' => $data['course_id'],
            'name' => $data['name']
        ]);
    }

    public function delete(int $id): void
    {
        $section = Section::FindOrFail($id);
        $section->delete();
    }

    // web
    public function updateSection(array $data): void
    {
        $section = Section::FindOrFail($data['section_id']);
        $section->update([
            'course_id' => $data['course_id'],
            'name' => $data['name']
        ]);
    }
}
