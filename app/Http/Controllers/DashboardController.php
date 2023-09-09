<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Models\Permit;
use App\Models\Presence;
use App\Models\Product;
use App\Models\User;
use App\Models\Worker;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = User::query();
        $product = Product::query();
        $latestProducts = $product->active()->orderBy('created_at', 'desc')->take(3)->get();

        return inertia('dashboard', [
            'user' => $user->count(),
            'user_active' => $user->active()->count(),
            'product' => $product->count(),
            'product_active' => $product->active()->count(),
            'latest_products' => $latestProducts,
        ])->title('Dashboard');
    }
}
