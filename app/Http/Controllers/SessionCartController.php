<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SessionCartController extends Controller
{
    /**
     * Catalog Products
     */
    private $products = [
        1 => ['id' => 1, 'name' => 'MacBook Pro M4', 'price' => 1999.00, 'category' => 'Laptops', 'icon' => 'fa-laptop'],
        2 => ['id' => 2, 'name' => 'Wireless Noise-Canceling Headphones', 'price' => 299.50, 'category' => 'Audio', 'icon' => 'fa-headphones'],
        3 => ['id' => 3, 'name' => 'UltraWide Gaming Monitor 34"', 'price' => 699.99, 'category' => 'Monitors', 'icon' => 'fa-desktop'],
        4 => ['id' => 4, 'name' => 'Mechanical RGB Keyboard', 'price' => 129.00, 'category' => 'Accessories', 'icon' => 'fa-keyboard'],
    ];

    /**
     * Display Session Shopping Cart & Checkout Wizard
     */
    public function index(Request $request)
    {
        $products = $this->products;
        $cart = $request->session()->get('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = round($subtotal * 0.08, 2);
        $total = round($subtotal + $tax, 2);

        $checkoutData = $request->session()->get('checkout', []);

        return view('cart.index', compact('products', 'cart', 'subtotal', 'tax', 'total', 'checkoutData'));
    }

    /**
     * Add Item to Session Cart
     */
    public function addToCart(Request $request)
    {
        $productId = (int) $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (!isset($this->products[$productId])) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $product = $this->products[$productId];
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'category' => $product['category'],
                'icon' => $product['icon'],
                'quantity' => $quantity,
            ];
        }

        $request->session()->put('cart', $cart);

        // Record Activity Timeline
        $timeline = $request->session()->get('activity_timeline', []);
        array_unshift($timeline, [
            'title' => 'Cart Item Added',
            'description' => "Added {$quantity}x {$product['name']} to session cart.",
            'time' => now()->format('d M Y h:i:s A'),
        ]);
        $request->session()->put('activity_timeline', $timeline);

        return redirect()->back()->with('success', "{$product['name']} added to session cart!");
    }

    /**
     * Update Item Quantity in Session Cart
     */
    public function updateQuantity(Request $request)
    {
        $productId = (int) $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            $request->session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove Single Item from Session Cart
     */
    public function removeItem(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$id])) {
            $itemName = $cart[$id]['name'];
            unset($cart[$id]);
            $request->session()->put('cart', $cart);

            return redirect()->back()->with('success', "Removed {$itemName} from session cart.");
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    /**
     * Clear Entire Session Cart
     */
    public function clearCart(Request $request)
    {
        $request->session()->forget('cart');
        $request->session()->forget('checkout');

        $timeline = $request->session()->get('activity_timeline', []);
        array_unshift($timeline, [
            'title' => 'Cart Cleared',
            'description' => 'Session shopping cart flushed.',
            'time' => now()->format('d M Y h:i:s A'),
        ]);
        $request->session()->put('activity_timeline', $timeline);

        return redirect()->back()->with('info', 'Session shopping cart cleared.');
    }

    /**
     * Multi-Step Checkout Session Wizard
     */
    public function processWizardStep(Request $request)
    {
        $step = (int) $request->input('step', 1);
        $checkout = $request->session()->get('checkout', []);

        if ($step === 1) {
            $request->validate([
                'customer_name' => 'required|string|max:100',
                'customer_email' => 'required|email',
                'customer_phone' => 'required|string',
            ]);

            $checkout['step1'] = [
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ];
            $checkout['current_step'] = 2;
            $request->session()->put('checkout', $checkout);

            return redirect()->back()->with('success', 'Step 1: Customer details saved in session!');
        }

        if ($step === 2) {
            $request->validate([
                'shipping_address' => 'required|string',
                'shipping_city' => 'required|string',
                'shipping_zip' => 'required|string',
            ]);

            $checkout['step2'] = [
                'address' => $request->shipping_address,
                'city' => $request->shipping_city,
                'zip' => $request->shipping_zip,
            ];
            $checkout['current_step'] = 3;
            $request->session()->put('checkout', $checkout);

            return redirect()->back()->with('success', 'Step 2: Shipping address saved in session!');
        }

        if ($step === 3) {
            // Confirm Final Order
            $cart = $request->session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->back()->with('error', 'Cannot complete order with an empty cart.');
            }

            $orderId = 'ORD-' . strtoupper(Str::random(8));
            $request->session()->forget('cart');
            $request->session()->forget('checkout');

            $timeline = $request->session()->get('activity_timeline', []);
            array_unshift($timeline, [
                'title' => 'Order Completed',
                'description' => "Order #{$orderId} placed via 3-Step Checkout Wizard!",
                'time' => now()->format('d M Y h:i:s A'),
            ]);
            $request->session()->put('activity_timeline', $timeline);

            return redirect()->back()->with('success', "🎉 Order #{$orderId} placed successfully via Session Wizard!");
        }

        return redirect()->back();
    }

    /**
     * Backup Cart Session to Downloadable JSON File
     */
    public function backupCart(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $filename = 'cart_backup_' . date('Y_m_d_His') . '.json';

        return response()->json([
            'cart' => $cart,
            'timestamp' => now()->toIso8601String(),
            'session_id' => $request->session()->getId(),
        ], 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Restore Cart Session from JSON Payload
     */
    public function restoreCart(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json,txt',
        ]);

        if ($request->hasFile('backup_file')) {
            $jsonContent = file_get_contents($request->file('backup_file')->getPathname());
            $data = json_decode($jsonContent, true);

            if (isset($data['cart']) && is_array($data['cart'])) {
                $request->session()->put('cart', $data['cart']);
                return redirect()->back()->with('success', 'Session cart restored successfully from JSON backup!');
            }
        }

        return redirect()->back()->with('error', 'Invalid JSON backup file format.');
    }
}
