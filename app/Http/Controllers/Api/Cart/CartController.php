<?php

namespace App\Http\Controllers\Api\Cart;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repository\Cart\CartContract;
use App\Http\Requests\Cart\CartRequest;

class CartController extends Controller
{
    private CartContract $cartContract;

    /**
     * @param  CartContract  $cartContract
     */
    public function __construct(CartContract $cartContract)
    {
        $this->cartContract = $cartContract;
    }

    /**
     * @DELETE /cart/{id}
     * @param  int  $id
     * @return JsonResponse|mixed
     */
    public function delete(int $id): mixed
    {
        try {
            $this->cartContract->delete($id);
            return $this->successResponse([
                'message' => "Item removed from cart successfully",
            ]);
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * @GET /cart
     * Get all cart items.
     *
     * @return JsonResponse|mixed
     */
    public function index(): mixed
    {
        try {
            return $this->successResponse([
                'message' => "cart items fetched successfully",
                'data'    => $this->cartContract->all(request('session_id')),
            ]);
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * @POST /cart
     * Store
     * @param  CartRequest  $request
     * @return mixed
     */
    public function store(CartRequest $request): mixed
    {
        try {
            return $this->successResponse([
                'message' => 'item added to cart successfully',
                'data' => $this->cartContract->create(array_merge($request->all(), ['session_id' => request('session_id', now()->timestamp)]))
            ]);
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * @PUT /cart/{id}
     * Update cart item
     * @param  CartRequest  $request
     * @param  int  $id
     * @return JsonResponse|mixed
     */
    public function update(CartRequest $request, int $id): mixed
    {
        try {
            return $this->successResponse([
                'message' => 'cart item updated successfully',
                'data' => $this->cartContract->update($id, $request->only(['product_id', 'user_id', 'qty']))
            ]);
        }catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }
}
