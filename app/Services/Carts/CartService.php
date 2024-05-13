<?php

declare(strict_types=1);

namespace App\Services\Carts;

use App\Models\Cart;
use App\Models\Course;
use Illuminate\Support\Facades\Cookie;
use Ramsey\Uuid\Uuid;

class CartService
{
    public function isCourseInCart($courseId)
    {
        return Cart::where('user_id', \Auth::id())->where('course_id', $courseId)->first() ? true : false;
    }

    public function index()
    {
        $userId = \Auth::id();
        $cart = Cart::with('course')
            ->where('id', $this->getCartId())
            ->when($userId, function ($query, $userId) {
                $query->where('user_id', $userId)->orWhereNull('user_id');
            })
            ->get();
        return $cart;
    }

    public function store($data)
    {
        $course = Course::findOrFail($data['course_id']);
        $price = $course->price;
        $couponUser = CouponUser::where('user_id', \Auth::id())->where('course_id', $course_id)->first();
        if ($couponUser) {
            $price = $couponUser->price_after_coupon;
        }

        Cart::updateOrCreate([
            'id' => $this->getCartId(),
            'user_id' => \Auth::id(),
            'course_id' => $course->id,
        ], [
            'price' => $price,
        ]);
    }

    public function delete($data, $id)
    {
        Cart::where('id', $id)->where('course_id', $data['course_id'])->delete();
    }

    private function getCartId()
    {
        $request = request();
        $id = $request->cookie('cart_id');
        if (!$id) {
            $uuid = Uuid::uuid1();
            $id = $uuid->toString();
            Cookie::queue(Cookie::make('cart_id', $id, 43800));
        }
        return $id;
    }

}