<?php

namespace App\Http\Controllers;

use App\Http\Requests\Catalog\CatalogFilterRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Services\Catalog\CatalogService;
use App\Services\Catalog\CategoryService;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService,
        protected CategoryService $categoryService
    ) {}

    /**
     * Отображает каталог товаров.
     */
    public function index(CatalogFilterRequest $request): Response
    {
        $filters = $request->filters();
        $products = $this->catalogService->getProducts($filters);
        $categories = $this->categoryService->getAll();

        return Inertia::render('Catalog/Index', [
            'products' => ProductResource::collection($products),
            'categories' => CategoryResource::collection($categories),
            'filters' => $filters,
        ]);
    }

    /**
     * Отображает товары категории.
     */
    public function category(CatalogFilterRequest $request, string $slug): Response
    {
        $category = $this->categoryService->getBySlug($slug);

        if (!$category) {
            abort(404);
        }

        $filters = array_merge($request->filters(), ['category' => $slug]);
        $products = $this->catalogService->getProducts($filters);
        $categories = $this->categoryService->getAll();

        return Inertia::render('Catalog/Index', [
            'products' => ProductResource::collection($products),
            'categories' => CategoryResource::collection($categories),
            'currentCategory' => new CategoryResource($category),
            'filters' => $filters,
        ]);
    }
}
