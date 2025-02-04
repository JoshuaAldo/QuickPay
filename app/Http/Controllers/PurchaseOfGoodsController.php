<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PurchaseOfGoodsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // $purchases = Auth::user()->purchases;
        $redirect = "purchase-of-goods";

        // Defaultkan query untuk mengambil semua orders milik user yang sedang login
        $query = Purchase::where('user_id', $user->id);

        // Cek apakah ada parameter tanggal mulai dan tanggal akhir dalam request
        if ($request->has('start_date') && $request->has('end_date')) {
            // Pastikan format tanggal sesuai dengan format di database
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->startOfDay(); // Mulai hari
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->endOfDay(); // Akhir hari

            // Filter berdasarkan rentang tanggal
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }

        // Mengambil semua orders yang sudah difilter
        $purchases = $query->get();

        return view('purchase_of_Goods.index', compact('redirect', 'purchases',));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'item_name' => 'required|string|max:255|unique:purchases,item_name',
            'quantity' => 'required|numeric',
            'transaction_date' => now(),
            'payment_method' => 'required|string',
            'item_category' => 'required|string',
            'price' => 'required|numeric',
        ]);

        // Persiapkan data produk
        $productData = [
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'transaction_date' => now(),
            'payment_method' => $request->payment_method,
            'item_category' => $request->item_category,
            'price' => $request->price,
            'total_price' => $request->quantity * $request->price,
        ];


        // Tambahkan produk baru untuk user yang sedang login
        Auth::user()->purchases()->create($productData);
        $purchases = Auth::user()->purchases;
        $redirect = "purchase-of-goods";
        return redirect()->route('purchase-of-goods.index')->with('success', 'Purchases added successfully.')->with('redirect', $redirect)->with('purchases', $purchases);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);

        if ($purchase) {
            $purchase->delete();
            return redirect()->route('purchase-of-goods.index')->with('success', 'Purchase of Goods deleted successfully');
        }

        return redirect()->route('purchase-of-goods.index')->with('error', 'Purchase of Goods not found');
    }
}
