<?php

namespace App\Http\Controllers\Web\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Carts\CartService;
use App\Http\Requests\web\Carts\CartStoreRequest;
use App\Http\Requests\web\Carts\CartDeleteRequest;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->index();
        return view('cart', [
            'cart' => $cart,
        ]);
    }

    public function store(CartStoreRequest $request)
    {
        $data = $request->validated();
        $this->cartService->store($data);
        return redirect()
            ->route('carts.index')
            ->with('success', __('Course successfully added to cart!'));
    }

    public function delete(CartDeleteRequest $request, $id)
    {
        $data = $request->validated();
        $this->cartService->delete($data, $id);
        return response()->json(['success' => "Item removed Successfully."]);

    }
}
