<?php

namespace App\Repository\Cart;

interface CartContract
{
    /**
     * Get all cart items.
     *
     * @param  string  $session_id
     * @return mixed
     */
    public function all(string $session_id);


    /**
     * add item to cart
     *
     * @param  array  $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Delete cart item.
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * Get cart item by id.
     * @param  int  $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * update cart items
     *
     * @param  int  $id
     * @param  array  $data
     * @return mixed
     */
    public function update(int $id, array $data);
}