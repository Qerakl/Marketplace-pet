<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Services\Home\HomePageService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        protected HomePageService $homePageService
    ) {}

    /**
     * Отображает главную страницу.
     */
    public function __invoke(): Response
    {
        $data = $this->homePageService->getData();

        return Inertia::render('Welcome', [
            'categories' => CategoryResource::collection($data['categories']),
            'featured' => ProductResource::collection($data['featured']),
            'stats' => $data['stats'],
        ]);
    }
}
