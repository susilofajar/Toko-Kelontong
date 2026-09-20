<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $threshold = (int) Setting::get('low_stock_threshold', 10);

        // Today's sales
        $salesToday = Sale::whereDate('created_at', $today)->sum('total_amount');
        $transactionsToday = Sale::whereDate('created_at', $today)->count();

        // Total products
        $totalProducts = Product::count();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', $threshold)->with('category')->get();
        $lowStockCount = $lowStockProducts->count();

        // Monthly sales data (last 12 months)
        $monthlySales = Sale::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $chartLabels = [];
        $chartData = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartLabels[] = $months[$date->month - 1] . ' ' . $date->year;
            $found = $monthlySales->first(fn($s) => $s->month == $date->month && $s->year == $date->year);
            $chartData[] = $found ? (float) $found->total : 0;
        }

        // Best-selling products (top 5)
        $bestSelling = SaleDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'salesToday',
            'transactionsToday',
            'totalProducts',
            'lowStockCount',
            'lowStockProducts',
            'chartLabels',
            'chartData',
            'bestSelling'
        ));
    }
}
