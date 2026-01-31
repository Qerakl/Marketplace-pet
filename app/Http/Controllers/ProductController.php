<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\Catalog\CatalogService;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ProductController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService
    ) {}

    /**
     * Отображает страницу товара.
     */
    public function show(string $slug): Response
    {
        $product = $this->catalogService->getProductBySlug($slug);

        if (!$product) {
            abort(HttpResponse::HTTP_NOT_FOUND);
        }

        $this->catalogService->incrementViews($product);
        $similar = $this->catalogService->getSimilarProducts($product);

        return Inertia::render('Products/Show', [
            'product' => new ProductResource($product),
            'similar' => ProductResource::collection($similar),
        ]);
    }
}
