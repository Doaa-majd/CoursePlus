<?php

namespace App\Http\Controllers\Web\Locale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Locale\LocaleService;
use App\Http\Requests\web\Locale\LocaleStoreRequest;

class LocaleController extends Controller
{
    protected $localeService;

    public function __construct(LocaleService $localeService)
    {
        $this->localeService = $localeService;
    }

    public function store(LocaleStoreRequest $request)
    {
        $data = $request->validated();
        $this->localeService->changeLang($data);
        return response()->json(['success' => "Lang changed"]);
    }
}
