<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));

        $sales = Sale::with(['details.product', 'user', 'customer'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();

        return view('reports.daily', compact('sales', 'date', 'totalSales', 'totalTransactions'));
    }

    public function monthly(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $year = (int) substr($month, 0, 4);
        $m = (int) substr($month, 5, 2);

        $dailySales = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as transactions'),
            DB::raw('SUM(total_amount) as total')
        )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $m)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalSales = $dailySales->sum('total');
        $totalTransactions = $dailySales->sum('transactions');

        $chartLabels = $dailySales->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $chartData = $dailySales->pluck('total')->toArray();

        return view('reports.monthly', compact('dailySales', 'month', 'totalSales', 'totalTransactions', 'chartLabels', 'chartData'));
    }

    public function yearly(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        $monthlySales = Sale::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as transactions'),
            DB::raw('SUM(total_amount) as total')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $totalSales = $monthlySales->sum('total');
        $totalTransactions = $monthlySales->sum('transactions');

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $months[$i - 1];
            $found = $monthlySales->first(fn($s) => $s->month == $i);
            $chartData[] = $found ? (float) $found->total : 0;
        }

        return view('reports.yearly', compact('monthlySales', 'year', 'totalSales', 'totalTransactions', 'chartLabels', 'chartData'));
    }

    public function bestSelling(Request $request)
    {
        $period = $request->get('period', 'all');

        $query = SaleDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
            ->with('product.category')
            ->groupBy('product_id');

        if ($period === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $bestSelling = $query->orderByDesc('total_qty')->limit(20)->get();

        return view('reports.best-selling', compact('bestSelling', 'period'));
    }

    public function profitLoss(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $year = (int) substr($month, 0, 4);
        $m = (int) substr($month, 5, 2);

        $dailyData = DB::table('sales')
            ->join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            ->select(
                DB::raw('DATE(sales.created_at) as date'),
                DB::raw('SUM(sale_details.subtotal) as revenue'),
                DB::raw('SUM(sale_details.purchase_price * sale_details.quantity) as cost')
            )
            ->whereYear('sales.created_at', $year)
            ->whereMonth('sales.created_at', $m)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalRevenue = $dailyData->sum('revenue');
        $totalCost = $dailyData->sum('cost');
        $netProfit = $totalRevenue - $totalCost;

        return view('reports.profit-loss', compact('month', 'dailyData', 'totalRevenue', 'totalCost', 'netProfit'));
    }

    public function exportDailyPdf(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $sales = Sale::with(['details.product', 'user', 'customer'])
            ->whereDate('created_at', $date)->latest()->get();
        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();
        $storeName = Setting::get('store_name', 'Toko Kelontong');
        $storeAddress = Setting::get('store_address', '');

        $pdf = Pdf::loadView('reports.daily-pdf', compact('sales', 'date', 'totalSales', 'totalTransactions', 'storeName', 'storeAddress'));
        return $pdf->download("laporan-harian-{$date}.pdf");
    }

    public function exportMonthlyPdf(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $year = (int) substr($month, 0, 4);
        $m = (int) substr($month, 5, 2);

        $dailySales = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as transactions'),
            DB::raw('SUM(total_amount) as total')
        )->whereYear('created_at', $year)->whereMonth('created_at', $m)
            ->groupBy('date')->orderBy('date')->get();

        $totalSales = $dailySales->sum('total');
        $totalTransactions = $dailySales->sum('transactions');
        $storeName = Setting::get('store_name', 'Toko Kelontong');
        $storeAddress = Setting::get('store_address', '');

        $pdf = Pdf::loadView('reports.monthly-pdf', compact('dailySales', 'month', 'totalSales', 'totalTransactions', 'storeName', 'storeAddress'));
        return $pdf->download("laporan-bulanan-{$month}.pdf");
    }
}
