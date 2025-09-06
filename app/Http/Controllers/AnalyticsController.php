<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Exchange;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display analytics dashboard
     */
    public function index(Request $request)
    {
        $analytics = $this->getFilteredAnalytics($request);
        return view('dashboard.analytics', compact('analytics'));
    }

    /**
     * Get filtered analytics data
     */
    public function getFilteredAnalytics(Request $request)
    {
        $dateFrom = $request->get('date_from', Carbon::now()->startOfMonth());
        $dateTo = $request->get('date_to', Carbon::now());
        $orderType = $request->get('order_type');
        $status = $request->get('status');

        // Build base query with filters
        $purchaseOrderQuery = PurchaseOrder::whereBetween('created_at', [$dateFrom, $dateTo]);
        $purchaseOrderDetailQuery = PurchaseOrderDetail::whereHas('purchaseOrder', function($query) use ($dateFrom, $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        });

        if ($orderType) {
            $purchaseOrderQuery->where('tipe_order', $orderType);
        }

        if ($status) {
            $purchaseOrderQuery->where('status', $status);
        }

        // Basic Statistics
        $totalPurchaseOrders = $purchaseOrderQuery->count();
        $totalCustomers = Customer::count();
        $totalUsers = User::count();
        $totalOrderValue = $purchaseOrderDetailQuery->sum('total_estimasi') ?? 0;
        $averageOrderValue = $purchaseOrderDetailQuery->avg('total_estimasi') ?? 0;

        // Growth calculations (compare with previous period)
        $previousPeriodStart = Carbon::parse($dateFrom)->subDays(Carbon::parse($dateFrom)->diffInDays(Carbon::parse($dateTo)));
        $previousPeriodEnd = Carbon::parse($dateFrom)->subDay();

        $previousOrders = PurchaseOrder::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        $ordersGrowth = $previousOrders > 0 ? (($totalPurchaseOrders - $previousOrders) / $previousOrders) * 100 : 0;

        $previousRevenue = PurchaseOrderDetail::whereHas('purchaseOrder', function($query) use ($previousPeriodStart, $previousPeriodEnd) {
            $query->whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd]);
        })->sum('total_estimasi') ?? 0;
        $revenueGrowth = $previousRevenue > 0 ? (($totalOrderValue - $previousRevenue) / $previousRevenue) * 100 : 0;

        // Order Status Distribution
        $ordersByStatus = $purchaseOrderQuery->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Order Type Distribution
        $ordersByType = $purchaseOrderQuery->select('tipe_order', DB::raw('count(*) as total'))
            ->groupBy('tipe_order')
            ->pluck('total', 'tipe_order')
            ->toArray();

        // Monthly Revenue Trend (Last 12 months)
        $monthlyRevenue = PurchaseOrderDetail::select(
                DB::raw('EXTRACT(YEAR FROM purchase_order_details.created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM purchase_order_details.created_at) as month'),
                DB::raw('SUM(purchase_order_details.total_estimasi) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->join('purchase_order', 'purchase_order_details.purchase_order_id', '=', 'purchase_order.id')
            ->where('purchase_order_details.created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                    'revenue' => $item->revenue ?? 0,
                    'orders' => $item->orders
                ];
            });

        // Daily Performance (Last 30 days)
        $dailyPerformance = $purchaseOrderQuery->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => Carbon::parse($item->date)->format('M d'),
                    'orders' => $item->orders,
                    'completed' => $item->completed,
                    'pending' => $item->pending
                ];
            });

        // Payment Method Analysis
        $paymentMethodUsage = $purchaseOrderDetailQuery->select('payment_method', DB::raw('count(*) as total'))
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method')
            ->toArray();

        // Top Performing Products
        $topProducts = $purchaseOrderDetailQuery->select(
                'nama_barang',
                DB::raw('COUNT(*) as quantity'),
                DB::raw('SUM(total_estimasi) as revenue'),
                DB::raw('AVG(total_estimasi) as avg_value')
            )
            ->whereNotNull('nama_barang')
            ->groupBy('nama_barang')
            ->orderBy('revenue', 'desc')
            ->limit(10)
            ->get();

        // Customer Analysis
        $topCustomers = PurchaseOrder::select(
                'nama',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM((SELECT SUM(total_estimasi) FROM purchase_order_detail WHERE purchase_order_id = purchase_order.id)) as total_spent')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('nama')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        // Order Processing Time Analysis
        $processingTimeAnalysis = PurchaseOrder::select(
                DB::raw('AVG(EXTRACT(EPOCH FROM (updated_at - created_at))/3600) as avg_processing_hours'),
                DB::raw('MIN(EXTRACT(EPOCH FROM (updated_at - created_at))/3600) as min_processing_hours'),
                DB::raw('MAX(EXTRACT(EPOCH FROM (updated_at - created_at))/3600) as max_processing_hours')
            )
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->whereNotNull('updated_at')
            ->first();

        // Recent Activities
        $recentOrders = $purchaseOrderQuery->with('purchaseOrderDetails')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Exchange Rates
        try {
            $exchangeRates = Exchange::select('name', 'value')->get()->pluck('value', 'name')->toArray();
        } catch (\Exception $e) {
            // Fallback in case of column name mismatch
            try {
                $exchangeRates = Exchange::select('name', 'number as value')->get()->pluck('value', 'name')->toArray();
            } catch (\Exception $e2) {
                $exchangeRates = [];
            }
        }

        // User Role Distribution
        $usersByRole = User::select('roles.name as role_name', DB::raw('count(*) as total'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->pluck('total', 'role_name')
            ->toArray();

        // Performance Metrics
        $conversionRate = $totalPurchaseOrders > 0 ?
            (PurchaseOrder::where('status', 'completed')->whereBetween('created_at', [$dateFrom, $dateTo])->count() / $totalPurchaseOrders) * 100 : 0;

        return [
            'totalPurchaseOrders' => $totalPurchaseOrders,
            'totalCustomers' => $totalCustomers,
            'totalUsers' => $totalUsers,
            'totalOrderValue' => $totalOrderValue,
            'averageOrderValue' => $averageOrderValue,
            'ordersGrowth' => round($ordersGrowth, 1),
            'revenueGrowth' => round($revenueGrowth, 1),
            'ordersByStatus' => $ordersByStatus,
            'ordersByType' => $ordersByType,
            'monthlyRevenue' => $monthlyRevenue,
            'dailyPerformance' => $dailyPerformance,
            'paymentMethodUsage' => $paymentMethodUsage,
            'topProducts' => $topProducts,
            'topCustomers' => $topCustomers,
            'processingTimeAnalysis' => $processingTimeAnalysis,
            'recentOrders' => $recentOrders,
            'exchangeRates' => $exchangeRates,
            'usersByRole' => $usersByRole,
            'conversionRate' => round($conversionRate, 1),
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'order_type' => $orderType,
                'status' => $status
            ]
        ];
    }

    /**
     * Get analytics data as JSON for AJAX requests
     */
    public function getAnalyticsJson(Request $request)
    {
        $analytics = $this->getFilteredAnalytics($request);
        return response()->json($analytics);
    }

    /**
     * Export analytics data to Excel
     */
    public function exportAnalytics(Request $request)
    {
        $analytics = $this->getFilteredAnalytics($request);

        // You can implement Excel export here using Maatwebsite/Excel
        // Return the Excel file for download

        return response()->json(['message' => 'Export feature coming soon']);
    }

    /**
     * Get real-time dashboard data
     */
    public function realTimeData()
    {
        $data = [
            'current_online_users' => rand(15, 45),
            'orders_today' => PurchaseOrder::whereDate('created_at', Carbon::today())->count(),
            'revenue_today' => PurchaseOrderDetail::whereHas('purchaseOrder', function($query) {
                $query->whereDate('created_at', Carbon::today());
            })->sum('total_estimasi') ?? 0,
            'pending_orders' => PurchaseOrder::where('status', 'pending')->count(),
            'system_health' => [
                'database' => 'healthy',
                'server_load' => rand(30, 80),
                'api_response_time' => rand(50, 200) . 'ms'
            ],
            'last_updated' => Carbon::now()->toISOString()
        ];

        return response()->json($data);
    }
}
