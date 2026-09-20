<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            /* Sizing */
            --sidebar-width: 280px;
            --topbar-height: 70px;

            /* Premium Dark Theme (Default) */
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #818cf8;
            --primary-glow: rgba(79, 70, 229, 0.4);

            --bg-body: #09090b;
            /* Zinc 950 */
            --bg-sidebar: #18181b;
            /* Zinc 900 */
            --bg-card: #18181b;
            --bg-card-hover: #27272a;
            /* Zinc 800 */
            --bg-glass: rgba(24, 24, 27, 0.7);

            --text-primary: #fafafa;
            /* Zinc 50 */
            --text-secondary: #a1a1aa;
            /* Zinc 400 */
            --text-muted: #a1a1aa;
            /* Zinc 400 */
            /* Brightened from zinc-500 for better contrast */

            --border-color: #27272a;
            /* Zinc 800 */
            --border-light: rgba(255, 255, 255, 0.1);

            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;

            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.15);
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
        }

        /* Premium Dark Mode Variabel Spesifik */
        body.theme-dark {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-sidebar: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --primary: #818cf8;
            /* Softer indigo for dark mode links */
            --primary-hover: #6366f1;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.4);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.4), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --input-bg: #1e293b;
            /* Distinct background slightly lighter than body, matching cards */
            --input-border: #475569;
            /* Slate 600 - much more visible border */
            --input-focus-border: var(--primary);
        }

        /* Premium Light Mode */
        body.theme-light {
            --bg-body: #f8fafc;
            /* Slate 50 */
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --bg-card-hover: #f1f5f9;
            /* Slate 100 */
            --bg-glass: rgba(255, 255, 255, 0.8);

            --text-primary: #0f172a;
            /* Slate 900 */
            --text-secondary: #475569;
            /* Slate 600 */
            --text-muted: #94a3b8;
            /* Slate 400 */

            --border-color: #e2e8f0;
            /* Slate 200 */
            --border-light: rgba(0, 0, 0, 0.03);

            --shadow-md: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --input-focus-border: var(--primary);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global Overrides for Bootstrap Defaults */
        :root {
            --bs-body-bg: var(--bg-body);
            --bs-body-color: var(--text-primary);
            --bs-heading-color: var(--text-primary);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            color: var(--text-primary) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            z-index: 1040;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .sidebar-brand h5 {
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            color: var(--text-primary);
        }

        .sidebar-brand small {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav .nav-link:hover {
            color: var(--text-primary);
            background: rgba(99, 102, 241, 0.08);
        }

        .sidebar-nav .nav-link.active {
            color: var(--primary-light);
            background: rgba(99, 102, 241, 0.12);
            border-left-color: var(--primary);
        }

        .sidebar-nav .nav-link i {
            font-size: 1.125rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #a855f7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .user-info .name {
            font-weight: 600;
            font-size: 0.8rem;
        }

        .user-info .role {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .topbar {
            height: var(--topbar-height);
            padding: 0 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: var(--shadow-sm);
        }

        .topbar h4 {
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
            color: var(--text-primary);
        }

        .card {
            color: var(--text-primary);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Tables */
        .table {
            color: var(--text-primary);
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-primary);
        }

        .table td,
        .table th {
            background-color: transparent !important;
        }

        .table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.04) !important;
        }

        /* Buttons */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.6rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            /* Explicitly white for primary btn contrast */
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px var(--primary-glow);
            color: #fff;
        }

        .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-outline-secondary:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
            border-color: var(--text-muted);
        }

        .btn-secondary {
            background: var(--bg-card-hover);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Premium Forms */
        .form-control,
        .form-select {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--input-bg);
            border-color: var(--input-focus-border);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        /* Fix for dark mode autocomplete */
        body.theme-dark .form-control:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px #1e293b inset !important;
            -webkit-text-fill-color: #f8fafc !important;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* Light mode specific element overrides that need exact colors */
        body.theme-light .card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        body.theme-light .table thead th {
            background: #f8fafc;
            color: #475569;
        }

        body.theme-light .stat-card::after {
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
        }

        body.theme-light .btn-outline-secondary:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        body.theme-light .pagination .page-link {
            background: #ffffff;
            border-color: #e2e8f0;
            color: #475569;
        }

        body.theme-light .pagination .page-item.active .page-link {
            color: #ffffff;
        }

        /* Badges */
        .badge {
            padding: 0.35em 0.65em;
            font-weight: 600;
            border-radius: 6px;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .badge-info {
            background: rgba(14, 165, 233, 0.15);
            color: var(--info);
        }

        .badge-primary {
            background: rgba(129, 140, 248, 0.15);
            color: var(--primary-light);
        }

        /* Modal */
        .modal-content {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            color: var(--text-primary);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
        }

        .modal-title {
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Pagination overrides for Dark & Light Mode */
        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            background: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-secondary);
            font-size: 0.875rem;
            padding: 0.5rem 0.875rem;
        }

        .pagination .page-link:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            background: var(--bg-body);
            color: var(--text-muted);
            border-color: var(--border-color);
            opacity: 0.6;
        }

        /* ===== Bootstrap Utility Overrides for Theme Compat ===== */
        .bg-white {
            background-color: var(--bg-card) !important;
        }

        .bg-light {
            background-color: var(--bg-body) !important;
        }

        .text-dark {
            color: var(--text-primary) !important;
        }

        .text-body {
            color: var(--text-primary) !important;
        }

        .border-bottom {
            border-bottom-color: var(--border-color) !important;
        }

        .border-top {
            border-top-color: var(--border-color) !important;
        }

        .border-start {
            border-left-color: var(--border-color) !important;
        }

        .border-end {
            border-right-color: var(--border-color) !important;
        }

        .card-footer {
            background: var(--bg-card) !important;
            border-top: 1px solid var(--border-color);
        }

        .thead-light th {
            background-color: transparent !important;
        }

        .btn-close {
            filter: var(--bs-btn-close-filter, invert(0));
        }

        body:not(.theme-light) .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Dropdown */
        .dropdown-menu {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .dropdown-item {
            color: var(--text-secondary);
        }

        .dropdown-item:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        /* Breadcrumb / small overrides */
        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--text-muted);
        }

        .breadcrumb-item a {
            color: var(--primary-light);
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        /* List group */
        .list-group-item {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        /* form-check in dark mode */
        .form-check-input {
            background-color: var(--bg-body);
            border-color: var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 1.25rem;
            cursor: pointer;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.5);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .topbar {
                padding: 0 1rem;
            }

            .content-area {
                padding: 1rem;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                z-index: 1035;
                transition: opacity 0.3s;
                opacity: 0;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
    </style>

    <!-- Theme Initialization Script -->
    <script>
        const savedTheme = localStorage.getItem('theme') || 'dark';
        if (savedTheme === 'light') {
            // Apply a pre-load class or script to body if possible, but body isn't parsed yet.
            // We'll apply it immediately after body opens.
        }
    </script>

    @stack('styles')
</head>

<body class="theme-dark">
    <!-- Immediate theme application to prevent flash -->
    <script>
        if (localStorage.getItem('theme') === 'light') { document.body.classList.add('theme-light'); }
    </script>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-shop"></i></div>
            <div>
                <h5>Toko Kelontong</h5>
                <small>Management System</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">MENU UTAMA</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            @if(auth()->user()->isAdmin())
                <div class="nav-section">MASTER DATA</div>
                <a href="{{ route('products.index') }}"
                    class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i> Produk
                </a>
                <a href="{{ route('categories.index') }}"
                    class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i> Kategori
                </a>
                <a href="{{ route('suppliers.index') }}"
                    class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> Supplier
                </a>
                <a href="{{ route('customers.index') }}"
                    class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Pelanggan
                </a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isCashier())
                <div class="nav-section">TRANSAKSI</div>
                <a href="{{ route('pos.index') }}" class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check-fill"></i> Kasir (POS)
                </a>
                <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt-cutoff"></i> Riwayat Penjualan
                </a>
                <a href="{{ route('debts.index') }}" class="nav-link {{ request()->routeIs('debts.*') ? 'active' : '' }}">
                    <i class="bi bi-book-half"></i> Buku Hutang
                </a>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="nav-section">STOK</div>
                <a href="{{ route('inventory.index') }}"
                    class="nav-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data-fill"></i> Riwayat Stok
                </a>
                <a href="{{ route('inventory.stock-in') }}"
                    class="nav-link {{ request()->routeIs('inventory.stock-in') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-down"></i> Stok Masuk
                </a>
                <a href="{{ route('inventory.stock-out') }}"
                    class="nav-link {{ request()->routeIs('inventory.stock-out') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-up"></i> Stok Keluar
                </a>
                <a href="{{ route('inventory.low-stock') }}"
                    class="nav-link {{ request()->routeIs('inventory.low-stock') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle-fill"></i> Stok Menipis
                </a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                <div class="nav-section">LAPORAN</div>
                <a href="{{ route('reports.daily') }}"
                    class="nav-link {{ request()->routeIs('reports.daily') ? 'active' : '' }}">
                    <i class="bi bi-calendar-day-fill"></i> Harian
                </a>
                <a href="{{ route('reports.monthly') }}"
                    class="nav-link {{ request()->routeIs('reports.monthly') ? 'active' : '' }}">
                    <i class="bi bi-calendar-month-fill"></i> Bulanan
                </a>
                <a href="{{ route('reports.yearly') }}"
                    class="nav-link {{ request()->routeIs('reports.yearly') ? 'active' : '' }}">
                    <i class="bi bi-calendar-range-fill"></i> Tahunan
                </a>
                <a href="{{ route('reports.profit-loss') }}"
                    class="nav-link {{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i> Laba / Rugi
                </a>
                <a href="{{ route('reports.best-selling') }}"
                    class="nav-link {{ request()->routeIs('reports.best-selling') ? 'active' : '' }}">
                    <i class="bi bi-trophy-fill"></i> Produk Terlaris
                </a>
            @endif

            @if(auth()->user()->isAdmin())
                <div class="nav-section">PENGATURAN</div>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> User
                </a>
                <a href="{{ route('settings.index') }}"
                    class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i> Pengaturan
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('profile.edit') }}" class="user-info" style="text-decoration:none;">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div>
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="role">{{ auth()->user()->role }}</div>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
                <h4>@yield('title', 'Dashboard')</h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button id="themeToggleBtn" class="btn btn-icon"
                    style="color:var(--text-primary); background:transparent; border:none; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                </button>
                <div class="d-none d-md-block border-start border-secondary" style="height:24px; opacity:0.3;"></div>
                <div class="d-none d-md-block">
                    <span class="text-muted" style="font-size:0.8rem;">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius:10px;">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert"
                    style="background:rgba(34,197,94,0.1);border-color:rgba(34,197,94,0.3);color:var(--success);border-radius:12px;">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                    style="background:rgba(239,68,68,0.1);border-color:rgba(239,68,68,0.3);color:var(--danger);border-radius:12px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Theme Toggle Logic
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const body = document.body;

        function updateThemeIcon() {
            if (body.classList.contains('theme-light')) {
                themeIcon.className = 'bi bi-sun-fill text-warning';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill text-info';
            }
        }

        // Initial setup
        updateThemeIcon();

        themeBtn?.addEventListener('click', () => {
            body.classList.toggle('theme-light');
            const isLight = body.classList.contains('theme-light');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            updateThemeIcon();
        });

        // Format currency
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        // Delete confirmation with SweetAlert
        function confirmDelete(formId) {
            const isLight = document.body.classList.contains('theme-light');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#71717a',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: isLight ? '#ffffff' : '#18181b',
                color: isLight ? '#0f172a' : '#fafafa',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>

</html>