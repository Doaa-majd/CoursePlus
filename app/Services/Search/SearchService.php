<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Models\Course;

class SearchService
{

    public function getCourses($request)
    {
        $query = Course::query()->with('category');

        if ($request->has('search')) {
            $query->where('title', $request->search);
        }

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('id', $request->category);
            });
        }
        if ($request->has('min') && $request->min != null) {
            $query->where('price', '>=', $request->min);
        }
        if ($request->has('max') && $request->max != null) {
            $query->where('price', '<=', $request->max);
        }
        return $query->paginate(10);
    }
}