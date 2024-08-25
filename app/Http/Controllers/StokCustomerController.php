<?php

namespace App\Http\Controllers;

use App\Models\StokCustomer;
use Illuminate\Http\Request;

class StokCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $stokCustomerQuery = StokCustomer::with(['dataBarang', 'customer'])
            ->orderBy('created_at', 'DESC');

        if ($query) {
            $stokCustomerQuery->whereHas('dataBarang', function ($q) use ($query) {
                $q->where('nama_barang', 'LIKE', "%{$query}%");
            })
                ->orWhereHas('customer', function ($q) use ($query) {
                    $q->where('nama', 'LIKE', "%{$query}%");
                });
        }

        $stokCustomer = $stokCustomerQuery->paginate(5);

        return view('stokcustomer', compact('stokCustomer', 'query'));
    }
}
