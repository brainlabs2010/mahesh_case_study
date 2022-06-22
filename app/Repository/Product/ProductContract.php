<?php

namespace App\Repository\Product;

interface ProductContract
{
    /**
     * Get all products
     *
     * @param  array  $relations
     * @return mixed
     */
    public function all(array $relations = []): mixed;

    /**
     * create product
     *
     * @param  array  $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Remove given product.
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Get product by id.
     *
     * @param  int  $id
     * @param  array  $relations
     * @return mixed
     */
    public function getById(int $id, array $relations = []): mixed;

    /**
     * Update product by given id.
     *
     * @param  int  $id
     * @param  array  $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed;
}