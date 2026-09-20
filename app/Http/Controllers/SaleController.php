<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'customer', 'details.product'])->latest();

        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sales = $query->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'customer', 'details.product']);

        return response()->json([
            'invoice_number' => $sale->invoice_number,
            'date' => $sale->created_at->format('d M Y H:i'),
            'cashier' => $sale->user->name ?? '-',
            'customer' => $sale->customer->name ?? 'Umum',
            'total_amount' => $sale->total_amount,
            'payment_amount' => $sale->payment_amount,
            'change_amount' => $sale->change_amount,
            'items' => $sale->details->map(fn($d) => [
                'name' => $d->product->name ?? '-',
                'quantity' => $d->quantity,
                'unit_price' => $d->unit_price,
                'subtotal' => $d->subtotal,
            ]),
        ]);
    }
}
