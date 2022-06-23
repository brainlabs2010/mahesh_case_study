<?php

namespace App\Repository\Cart;

use App\Models\Cart;

class CartRepository implements CartContract
{
    private Cart $cart;

    /**
     * @param  Cart  $cart
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @inheritDoc
     */
    public function all(string $session_id)
    {
        return $this->cart->whereSessionId($session_id)->get();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        return $this->cart->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        $cart = $this->getById($id);
        return $cart->delete();
    }


    /**
     * @inheritDoc
     */
    public function getById(int $id)
    {
        return $this->cart->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data)
    {
        $cart = $this->getById($id);
        return tap($cart)->update($data);
    }

}