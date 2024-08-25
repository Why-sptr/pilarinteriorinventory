<?php

namespace App\Http\Controllers;

use App\Models\BiayaOperasional;
use App\Models\Customer;
use App\Models\DataBarang;
use App\Models\JenisBarang;
use App\Models\StokCustomer;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataBarangCount = DataBarang::count();
        $transaksiCount = Transaksi::count();
        $customerCount = Customer::count();

        $recentTransactions = Transaksi::with('dataBarang')
            ->latest()
            ->take(5)
            ->get();

        // Ambil bulan dan tahun dari request jika ada
        $selectedMonthYear = $request->input('monthYear');
        if ($selectedMonthYear) {
            list($year, $month) = explode('-', $selectedMonthYear);
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } else {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        }

        $overviewData = User::with(['customers' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->get()->map(function ($user) {
            return $user->customers->map(function ($customer) use ($user) {
                $stokCustomer = StokCustomer::with(['dataBarang'])
                    ->where('customer_id', $customer->id)
                    ->get();

                $biayaDipakai = 0;
                foreach ($stokCustomer as $stok) {
                    $jumlahKeluar = Transaksi::where('customer_id', $customer->id)
                        ->where('data_barang_id', $stok->data_barang_id)
                        ->where('status', 'keluar')
                        ->sum('jumlah');
                    $biayaDipakai += $jumlahKeluar * $stok->dataBarang->harga_barang;
                }

                $dana = $customer->dana;
                $grossProfit = $dana - $biayaDipakai;

                return [
                    'user_name' => $user->name,
                    'customer_name' => $customer->nama,
                    'omset' => $dana,
                    'gross_profit' => $grossProfit,
                ];
            });
        })->flatten(1);

        $totalGrossProfit = $overviewData->sum('gross_profit');

        // Hitung biaya operasional bulan yang dipilih
        $biayaOperasionalTotal = BiayaOperasional::whereBetween('created_at', [$startDate, $endDate])->sum('biaya');

        // Hitung net profit
        $netProfit = $totalGrossProfit - $biayaOperasionalTotal;

        $customer = Customer::latest()->take(5)->get();

        // Generate list bulan dan tahun untuk filter
        $months = collect(range(1, 12))->map(function ($month) {
            $monthName = \Carbon\Carbon::create()->month($month)->format('F'); // Nama bulan
            $year = now()->year;
            return [
                'value' => "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT),
                'label' => "$monthName $year",
            ];
        });

        return view('index', compact('dataBarangCount', 'transaksiCount', 'customerCount', 'recentTransactions', 'overviewData', 'customer', 'netProfit', 'months'));
    }
}
