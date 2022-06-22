<?php

namespace App\Repository\Product;

use App\Models\Product;

class ProductRepository implements ProductContract
{
    private Product $product;

    /**
     * @param  Product  $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @inheritDoc
     */
    public function all(array $relations = []): mixed
    {
        return $this->product->with($relations)->paginate();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): mixed
    {
        return $this->product->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        $product = $this->getById($id);
        return $product->delete();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id, array $relations = []): mixed
    {
        return $this->product->with($relations)->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): mixed
    {
        $product = $this->getById($id);
        return tap($product)->update($data);
    }
}