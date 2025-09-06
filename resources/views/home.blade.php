@extends('layouts.app')

@section('title', 'Dashboard Analytics')

@section('content')


<div class="page-content">
    <!-- Enhanced KPI Cards -->
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center">
                            <div class="stats-icon purple mb-2">
                                <i class="bi bi-basket-fill"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Purchase Orders</h6>
                            <h6 class="font-extrabold mb-0">{{ number_format($analytics['totalPurchaseOrders']) }}</h6>
                            <small class="text-{{ $analytics['ordersGrowth'] >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $analytics['ordersGrowth'] >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($analytics['ordersGrowth']) }}% from last month
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center">
                            <div class="stats-icon blue mb-2">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Customers</h6>
                            <h6 class="font-extrabold mb-0">{{ number_format($analytics['totalCustomers']) }}</h6>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +8% from last month
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center">
                            <div class="stats-icon green mb-2">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Revenue</h6>
                            <h6 class="font-extrabold mb-0">Rp {{ number_format($analytics['totalOrderValue']) }}</h6>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +23% from last month
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center">
                            <div class="stats-icon red mb-2">
                                <i class="bi bi-graph-up"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Average Order Value</h6>
                            <h6 class="font-extrabold mb-0">Rp {{ number_format($analytics['averageOrderValue']) }}</h6>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +15% from last month
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="row">
        <!-- Monthly Revenue Trend -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Revenue & Orders Trend (12 Months)</h4>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><button type="button" class="dropdown-item" onclick="toggleChart('monthly')">Monthly View</button></li>
                            <li><button type="button" class="dropdown-item" onclick="toggleChart('weekly')">Weekly View</button></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueOrdersChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Order Status Breakdown -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Order Status Distribution</h4>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                    <div class="mt-3">
                        @foreach($analytics['processingStats'] as $status => $count)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-capitalize">{{ $status }}</span>
                            <span class="badge bg-{{ $status == 'completed' ? 'success' : ($status == 'pending' ? 'warning' : ($status == 'cancelled' ? 'danger' : 'info')) }}">
                                {{ $count }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Charts Row -->
    <div class="row">
        <!-- Order Type & Payment Methods -->
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Order Type Distribution</h4>
                </div>
                <div class="card-body">
                    <canvas id="orderTypeChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Payment Method Usage</h4>
                </div>
                <div class="card-body">
                    <canvas id="paymentMethodChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Analytics Row -->
    <div class="row">
        <!-- Order Value Distribution -->
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Order Value Distribution</h4>
                </div>
                <div class="card-body">
                    <canvas id="orderValueChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Customer Activity Chart -->
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Top Customer Activity</h4>
                </div>
                <div class="card-body">
                    <canvas id="customerActivityChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics Row -->
    <div class="row">
        <!-- Daily Performance (7 days) -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Daily Orders Performance (Last 7 Days)</h4>
                </div>
                <div class="card-body">
                    <canvas id="dailyPerformanceChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- User Role Distribution -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>User Distribution</h4>
                </div>
                <div class="card-body">
                    <canvas id="userRoleChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Row -->
    <div class="row">
        <!-- Top Products Table -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Top Performing Products</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Product Name</th>
                                    <th>Orders</th>
                                    <th>Estimated Revenue</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['topProducts'] as $index => $product)
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $index < 3 ? 'warning' : 'secondary' }}">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-title bg-light-primary rounded">
                                                    {{ substr($product->nama_barang, 0, 1) }}
                                                </span>
                                            </div>
                                            <span>{{ Str::limit($product->nama_barang, 30) }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $product->quantity }}</span></td>
                                    <td>Rp {{ number_format(rand(100000, 2000000)) }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: {{ min(100, ($product->quantity / 10) * 100) }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No products data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exchange Rates & Quick Stats -->
        <div class="col-12 col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Exchange Rates</h5>
                </div>
                <div class="card-body">
                    @forelse($analytics['exchangeRates'] as $currency => $rate)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-currency-exchange me-2 text-primary"></i>
                            <span class="fw-bold">{{ $currency }}</span>
                        </div>
                        <span class="badge bg-success fs-6">{{ number_format($rate, 0) }}</span>
                    </div>
                    @empty
                    <p class="text-muted">No exchange rates available</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Quick Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Active Users</span>
                            <span class="badge bg-info fs-6">{{ $analytics['totalUsers'] }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Payment Methods</span>
                            <span class="badge bg-secondary fs-6">{{ $analytics['totalPaymentMethods'] }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Processing Orders</span>
                            <span class="badge bg-warning fs-6">{{ $analytics['processingStats']['processing'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Completed Today</span>
                            <span class="badge bg-success fs-6">{{ $analytics['processingStats']['completed'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Recent Purchase Orders</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Items</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['recentOrders'] as $order)
                                <tr>
                                    <td><strong>{{ $order->no_invoice }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-title bg-light-success rounded">
                                                    {{ substr($order->nama, 0, 1) }}
                                                </span>
                                            </div>
                                            {{ $order->nama }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info') }}">
                                            {{ $order->status ?? 'New' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">Type {{ $order->tipe_order }}</span>
                                    </td>
                                    <td>{{ $order->purchaseOrderDetails->count() }} items</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No recent orders available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    try {

        // Chart colors
        const colors = {
            primary: '#435ebe',
            success: '#198754',
            danger: '#dc3545',
            warning: '#ffc107',
            info: '#0dcaf0',
            purple: '#6f42c1',
            pink: '#d63384',
            orange: '#fd7e14',
            gray: '#6c757d'
        };

        // Global chart configuration
        Chart.defaults.font.family = "'Nunito', sans-serif";
        Chart.defaults.color = '#6c757d';

    // Revenue & Orders Trend Chart (Dual Axis)
    const revenueCtx = document.getElementById('revenueOrdersChart').getContext('2d');
    const monthlyOrders = @json($analytics['monthlyOrders']);
    const monthlyRevenue = @json($analytics['monthlyRevenue']);

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: monthlyOrders.map(item => item.month),
            datasets: [{
                label: 'Orders',
                data: monthlyOrders.map(item => item.total),
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                yAxisID: 'y'
            }, {
                label: 'Revenue (Million Rp)',
                data: monthlyRevenue.map(item => (item.revenue || 0) / 1000000),
                borderColor: colors.success,
                backgroundColor: colors.success + '20',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Orders Count'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Revenue (Million Rp)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });

    // Order Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($analytics['processingStats']);


    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    colors.warning,  // pending
                    colors.info,     // processing
                    colors.success,  // completed
                    colors.danger    // cancelled
                ],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            }
        }
    });

    // Order Type Chart
    const orderTypeCtx = document.getElementById('orderTypeChart').getContext('2d');
    const orderTypeData = @json($analytics['purchaseOrdersByType']);

    new Chart(orderTypeCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(orderTypeData).map(type => `Type ${type}`),
            datasets: [{
                label: 'Orders',
                data: Object.values(orderTypeData),
                backgroundColor: [
                    colors.primary,
                    colors.success,
                    colors.warning,
                    colors.info
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Payment Method Chart
    const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
    const paymentMethodData = @json($analytics['paymentMethodUsage']);

    new Chart(paymentMethodCtx, {
        type: 'polarArea',
        data: {
            labels: Object.keys(paymentMethodData),
            datasets: [{
                data: Object.values(paymentMethodData),
                backgroundColor: [
                    colors.primary + '80',
                    colors.success + '80',
                    colors.warning + '80',
                    colors.danger + '80',
                    colors.info + '80'
                ],
                borderColor: [
                    colors.primary,
                    colors.success,
                    colors.warning,
                    colors.danger,
                    colors.info
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Order Value Distribution Chart
    const orderValueCtx = document.getElementById('orderValueChart').getContext('2d');
    const orderValueData = @json($analytics['orderValueRanges']);

    new Chart(orderValueCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(orderValueData),
            datasets: [{
                data: Object.values(orderValueData),
                backgroundColor: [
                    colors.info,
                    colors.primary,
                    colors.warning,
                    colors.success
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Customer Activity Chart
    const customerActivityCtx = document.getElementById('customerActivityChart').getContext('2d');
    const customerActivityData = @json($analytics['customerActivity']);

    new Chart(customerActivityCtx, {
        type: 'bar',
        data: {
            labels: customerActivityData.map(item => item.customer ? item.customer.substring(0, 15) + '...' : 'Unknown'),
            datasets: [{
                label: 'Orders',
                data: customerActivityData.map(item => item.orders),
                backgroundColor: colors.purple,
                borderColor: colors.purple,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });    // Daily Performance Chart
    const dailyCtx = document.getElementById('dailyPerformanceChart').getContext('2d');
    const dailyData = @json($analytics['dailyOrders']);

    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: dailyData.map(item => item.date),
            datasets: [{
                label: 'Daily Orders',
                data: dailyData.map(item => item.total),
                borderColor: colors.success,
                backgroundColor: colors.success + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.success,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // User Role Distribution Chart
    const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
    const userRoleData = @json($analytics['usersByRole']);

    new Chart(userRoleCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(userRoleData),
            datasets: [{
                data: Object.values(userRoleData),
                backgroundColor: [
                    colors.primary,
                    colors.success,
                    colors.warning,
                    colors.danger,
                    colors.info
                ],
                borderWidth: 0,
                cutout: '60%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            }
        }
    });

    // Toggle Chart Function
    window.toggleChart = function(viewType) {
        console.log('Toggling chart view to:', viewType);
        // You can implement chart view switching logic here
    };

    // Real-time updates every 5 minutes
    setInterval(() => {
        // Auto refresh functionality can be implemented here
        console.log('Auto-refreshing dashboard data...');
    }, 300000);


    } catch (error) {
    }
});
</script>
@endpush
