<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\DebtPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'debtPayments'])
            ->where('payment_method', 'kasbon')
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('invoice_number', 'like', "%{$search}%")
              ->where('payment_method', 'kasbon');
        }

        $debts = $query->paginate(15);
        return view('debts.index', compact('debts'));
    }

    public function pay(Request $request, Sale $sale)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:1',
            'note' => 'nullable|string'
        ]);

        if ($sale->payment_method !== 'kasbon' || $sale->payment_status === 'lunas') {
            return back()->with('error', 'Transaksi ini tidak bisa dibayar.');
        }

        $remainingDebt = $sale->total_amount - $sale->payment_amount;
        if ($request->payment_amount > $remainingDebt) {
            return back()->with('error', 'Jumlah pembayaran melebihi sisa hutang.');
        }

        try {
            DB::beginTransaction();

            $sale->payment_amount += $request->payment_amount;
            $sale->change_amount = $sale->payment_amount - $sale->total_amount;

            if ($sale->payment_amount >= $sale->total_amount) {
                $sale->payment_status = 'lunas';
                $sale->change_amount = max(0, $sale->change_amount);
            }
            $sale->save();

            DebtPayment::create([
                'sale_id' => $sale->id,
                'user_id' => auth()->id(),
                'payment_amount' => $request->payment_amount,
                'payment_date' => now(),
                'note' => $request->note ?: 'Pembayaran tagihan',
            ]);

            DB::commit();
            return back()->with('success', 'Pembayaran hutang berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
