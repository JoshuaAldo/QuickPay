<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    public function index()
    {
        // $userId = Auth::id();
        // $user = Auth::user();

        // $Orders = Order::with('items')
        //     ->where('user_id', $userId)
        //     ->get();
        // dd($Orders);
        $redirect = "sales-report";
        // return view('sales_report.index', compact('Orders', 'redirect'));

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mengambil semua orders milik user yang sedang login, termasuk items-nya
        $orders = Order::where('user_id', $user->id)->with('items')->get();

        // Menghitung total item_total untuk setiap order
        $ordersWithTotals = $orders->map(function ($order) {
            $order->total_item_value = $order->items->sum('item_total');
            return $order;
        });
        // dd($ordersWithTotals);
        // Mengirimkan data orders dengan total dan item details ke view
        return view('sales_report.index', compact('ordersWithTotals', 'redirect'));
    }
}
