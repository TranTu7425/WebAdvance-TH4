<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;


class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, 1, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        if($qty < 1) {
            Cart::instance('cart')->remove($rowId);
        } else {
            Cart::instance('cart')->update($rowId, $qty);
        }
        return redirect()->back()->with('success', 'Cart updated successfully');
    }
    
    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function update_quantity(Request $request, $rowId)
    {
        $qty = $request->quantity;
        if($qty < 1) {
            Cart::instance('cart')->remove($rowId);
        } else {
            Cart::instance('cart')->update($rowId, $qty);
        }
        return response()->json(['success' => true]);
    }

    public function apply_coupon(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if(isset($coupon_code)) {
            $coupon = Coupon::where('code', $coupon_code)->where('expiry_date', '>=', Carbon::today())->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
            if(!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon code');
            }
            else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value,
                ]);
                $this->calculateDiscount();
                return redirect()->back()->with('success', 'Coupon applied successfully');
            }
        }
        else {
            return redirect()->back()->with('error', 'Invalid coupon code');
        }
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if(Session::has('coupon')) {
            if(Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            }
            else {
                $discount = Cart::instance('cart')->subtotal() * Session::get('coupon')['value'] / 100;
            }

            $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
                'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
                'total' => number_format(floatval($totalAfterDiscount), 2, '.', ''),
            ]);
        }
    }

    public function remove_coupon()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back()->with('success', 'Coupon removed successfully');
    }

    public function checkout()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    public function place_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();
        if(!$address) {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|numeric|digits:10',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'locality' => 'required|string|max:255',
                'landmark' => 'required|string|max:255',
            ]);

            $address = new Address();
            $address->user_id = $user_id;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country ='Việt Nam';
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountforCheckout();

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout') ['tax'];
        $order->total = Session::get('checkout')['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        foreach(Cart::instance('cart')->content() as $item) {
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->product_id = $item->id;
            $order_item->quantity = $item->qty;
            $order_item->price = $item->price;
            $order_item->save();
        }

        if($request->mode == 'card') {
            //
        }
        elseif($request->mode == 'vnpay') {
            //
        }
        elseif($request->mode == 'cod') {
            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->user_id = $user_id;
            $transaction->mode = $request->mode;
            $transaction->status = 'pending';
            $transaction->save();
        }

        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);
        return redirect()->route('cart.order.confirmation');
    }

    public function setAmountforCheckout()
    {
        if(!Cart::instance('cart')->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if(Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        }
        else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function order_confirmation()
    {
        if(Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        else {
            return redirect()->route('cart.index');
        }
    }
}
