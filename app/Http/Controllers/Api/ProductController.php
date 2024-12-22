<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAllAvailable();
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = $this->productRepository->findById($id);
        return new ProductResource($product);
    }

    public function search(SearchProductRequest $request)
    {
        $products = $this->productRepository->search($request->term);
        return ProductResource::collection($products);
    }
}
