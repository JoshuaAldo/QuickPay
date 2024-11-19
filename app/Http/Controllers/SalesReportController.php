<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{

    public function index(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();
        $redirect = "sales-report";

        // Defaultkan query untuk mengambil semua orders milik user yang sedang login
        $query = Order::where('user_id', $user->id)->with('items');

        // Cek apakah ada parameter tanggal mulai dan tanggal akhir dalam request
        if ($request->has('start_date') && $request->has('end_date')) {
            // Pastikan format tanggal sesuai dengan format di database
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay(); // Mulai hari
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay(); // Akhir hari

            // Filter berdasarkan rentang tanggal
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        // Mengambil semua orders yang sudah difilter
        $orders = $query->get();

        // Menghitung total item_total untuk setiap order
        $ordersWithTotals = $orders->map(function ($order) {
            $discount = $order->discount;
            $totalOrder = $order->items->sum('item_total');
            $order->total_item_value = $totalOrder - $discount;
            return $order;
        });
        // Mengirimkan data orders dengan total dan item details ke view
        return view('sales_report.index', compact('ordersWithTotals', 'redirect'));
    }
}
