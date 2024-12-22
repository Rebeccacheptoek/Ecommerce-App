<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductRepository extends Controller
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAllAvailable()
    {
        return $this->model->inStock()->paginate(12);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function updateStock($id, $quantity, $increment = false)
    {
        $product = $this->findById($id);

        if ($increment) {
            $product->increment('stock', $quantity);
        } else {
            if ($product->stock < $quantity) {
                throw new \Exception('Insufficient stock');
            }
            $product->decrement('stock', $quantity);
        }

        return $product->fresh();
    }

    public function search($term)
    {
        return $this->model
            ->where('name', 'LIKE', "%{$term}%")
            ->orWhere('details', 'LIKE', "%{$term}%")
            ->orWhere('sku', 'LIKE', "%{$term}%")
            ->paginate(12);
    }
}
