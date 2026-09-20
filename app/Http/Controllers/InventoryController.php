<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Setting;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $movements = $query->latest()->paginate(20);
        $products = Product::orderBy('name')->get();

        return view('inventory.index', compact('movements', 'products'));
    }

    public function stockIn()
    {
        $products = Product::orderBy('name')->get();
        return view('inventory.stock-in', compact('products'));
    }

    public function processStockIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $product->increment('stock', $validated['quantity']);

        StockMovement::create([
            'product_id' => $validated['product_id'],
            'user_id' => auth()->id(),
            'type' => 'in',
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? 'Stok masuk manual',
        ]);

        return redirect()->route('inventory.index')
            ->with('success', "Stok {$product->name} berhasil ditambah {$validated['quantity']} unit.");
    }

    public function stockOut()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('inventory.stock-out', compact('products'));
    }

    public function processStockOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return back()->withErrors(['quantity' => "Stok tidak cukup. Stok saat ini: {$product->stock}"])->withInput();
        }

        $product->decrement('stock', $validated['quantity']);

        $note = $validated['reason'];
        if ($request->filled('note')) {
            $note .= ' - ' . $validated['note'];
        }

        StockMovement::create([
            'product_id' => $validated['product_id'],
            'user_id' => auth()->id(),
            'type' => 'out',
            'quantity' => $validated['quantity'],
            'note' => $note,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', "Stok {$product->name} berhasil dikurangi {$validated['quantity']} unit.");
    }

    public function lowStock()
    {
        $threshold = (int) Setting::get('low_stock_threshold', 10);
        $products = Product::where('stock', '<=', $threshold)
            ->with('category')
            ->orderBy('stock')
            ->get();

        return view('inventory.low-stock', compact('products', 'threshold'));
    }
}
