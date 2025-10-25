<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $usersData = $this->getUsersData();
        $productsData = $this->getProductsData();

        return view('dashboard.index', array_merge($usersData, $productsData));
    }

    private function getUsersData()
    {
        // Ambil User
        $users = User::all();

        // Statistik umum
        $totalActiveUsers = $users->where('status', 'Aktif')->count();
        $totalActiveAdmins = $users->where('status', 'Aktif')->where('role', 'Admin')->count();
        $totalActiveSellers = $users->where('status', 'Aktif')->where('role', 'Penjual')->count();
        $totalActiveVisitors = $users->where('status', 'Aktif')->where('role', 'Pengunjung')->count();

        // Line Chart Data
        $months = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->translatedFormat('M'));

        $activeUsersByMonth = collect(range(1, 12))->map(
            fn($month) =>
            User::where('status', 'Aktif')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count()
        );

        $inactiveUsersByMonth = collect(range(1, 12))->map(
            fn($month) =>
            User::where('status', '!=', 'Aktif')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count()
        );

        return [
            'totalActiveUsers' => $totalActiveUsers,
            'totalActiveAdmins' => $totalActiveAdmins,
            'totalActiveSellers' => $totalActiveSellers,
            'totalActiveVisitors' => $totalActiveVisitors,
            'months' => $months,
            'activeUsersByMonth' => $activeUsersByMonth,
            'inactiveUsersByMonth' => $inactiveUsersByMonth,
        ];
    }

    private function getProductsData()
    {
        // Statistik produk
        $totalProducts = Product::count();
        $draftProducts = Product::where('status', 'Draf')->count();
        $publishedProducts = Product::where('status', 'Terbit')->count();
        $archivedProducts = Product::where('status', 'Arsip')->count();

        // Months (reuse same months labels)
        $months = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->translatedFormat('M'));

        // Produk per status per month (for chart)
        $publishedByMonth = collect(range(1, 12))->map(
            fn($month) => Product::where('status', 'Terbit')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count()
        );

        $draftByMonth = collect(range(1, 12))->map(
            fn($month) => Product::where('status', 'Draf')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count()
        );

        $archivedByMonth = collect(range(1, 12))->map(
            fn($month) => Product::where('status', 'Arsip')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->count()
        );

        return [
            'totalProducts' => $totalProducts,
            'draftProducts' => $draftProducts,
            'publishedProducts' => $publishedProducts,
            'archivedProducts' => $archivedProducts,
            'productMonths' => $months,
            'publishedByMonth' => $publishedByMonth,
            'draftByMonth' => $draftByMonth,
            'archivedByMonth' => $archivedByMonth,
        ];
    }
}
