<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Страница FAQ.
     */
    public function faq(): Response
    {
        return Inertia::render('Faq');
    }

    /**
     * Страница "Как это работает".
     */
    public function howItWorks(): Response
    {
        return Inertia::render('HowItWorks');
    }

    /**
     * Страница категорий.
     */
    public function categories(): Response
    {
        $categories = Category::query()
            ->withCount('products')
            ->ordered()
            ->get();

        return Inertia::render('Categories', [
            'categories' => $categories,
        ]);
    }
}
