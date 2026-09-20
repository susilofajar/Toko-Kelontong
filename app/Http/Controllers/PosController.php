<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use App\Models\StockMovement;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->with('category')->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        return view('pos.index', compact('products', 'customers'));
    }

    public function searchProduct(Request $request)
    {
        $search = $request->get('q', '');
        $products = Product::where('stock', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('barcode', $search);
            })
            ->with('category')
            ->limit(20)
            ->get();

        return response()->json($products);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:tunai,kasbon',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $items = $request->items;

            // Validate stock and calculate total
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} tidak mencukupi. Tersedia: {$product->stock}"
                    ], 422);
                }
                $totalAmount += $product->selling_price * $item['quantity'];
            }

            $paymentAmount = $request->payment_amount ?: 0;
            
            if ($request->payment_method === 'tunai' && $paymentAmount < $totalAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran tunai kurang dari total belanja.'
                ], 422);
            }
            
            if ($request->payment_method === 'kasbon' && !$request->customer_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelanggan wajib dipilih untuk metode Kasbon.'
                ], 422);
            }

            $paymentStatus = 'lunas';
            $changeAmount = $paymentAmount - $totalAmount;
            $dueDate = null;

            if ($request->payment_method === 'kasbon' && $paymentAmount < $totalAmount) {
                $paymentStatus = 'belum_lunas';
                $changeAmount = 0;
                $dueDate = \Carbon\Carbon::now()->addDays(30);
            }

            // Create sale
            $sale = Sale::create([
                'invoice_number' => Sale::generateInvoiceNumber(),
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'total_amount' => $totalAmount,
                'payment_amount' => $paymentAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'due_date' => $dueDate,
            ]);
            
            if ($request->payment_method === 'kasbon' && $paymentAmount > 0) {
                \App\Models\DebtPayment::create([
                    'sale_id' => $sale->id,
                    'user_id' => auth()->id(),
                    'payment_amount' => $paymentAmount,
                    'payment_date' => now(),
                    'note' => 'Pembayaran awal ' . $sale->invoice_number,
                ]);
            }

            // Create sale details and update stock
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'purchase_price' => $product->purchase_price,
                    'unit_price' => $product->selling_price,
                    'subtotal' => $product->selling_price * $item['quantity'],
                ]);

                // Decrease stock
                $product->decrement('stock', $item['quantity']);

                // Record stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'note' => 'Penjualan #' . $sale->invoice_number,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'sale_id' => $sale->id,
                'invoice_number' => $sale->invoice_number,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function receipt(Sale $sale)
    {
        $sale->load(['details.product', 'user', 'customer']);
        $storeName = Setting::get('store_name', 'Toko Kelontong');
        $storeAddress = Setting::get('store_address', '');
        $storePhone = Setting::get('store_phone', '');

        return view('pos.receipt', compact('sale', 'storeName', 'storeAddress', 'storePhone'));
    }
}
