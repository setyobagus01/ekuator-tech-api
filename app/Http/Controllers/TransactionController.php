<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ApiResource('success', 200, 'Get list transactions', Transaction::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();

            $product = Product::find($request->product_id);

            if ($product->quantity == 0 || ($product->quantity - $input['quantity']) < 0) {
                return new ApiResource('error', 422, 'Stok barang kosong', null);
            }


            $input['price'] = 25000;
            $tax = 10;
            $admin = 5;

            $tax = $input['price'] * ($tax / 100);

            $formatted_tax = number_format($tax, 2, '.', '');

            $input['price'] = $product->price;

            $admin_fee = ($product->price + $formatted_tax) * ($admin / 100);
            $formatted_admin_fee = number_format($admin_fee, 2, '.', '');
            $input['tax'] = $formatted_tax;
            $input['admin_fee'] = $formatted_admin_fee;
            $input['total'] = ($product->price + $formatted_tax + $formatted_admin_fee) * $input['quantity'];
            $transaction = Transaction::create($input);

            $product->update(['quantity' => ($product->quantity - $input['quantity'])]);


            DB::commit();
            return new ApiResource('success', 200, 'Transaction success', $transaction);
        } catch (\Throwable $e) {
            DB::rollBack();
            return new ApiResource('error', 500, $e->getMessage(), null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ApiResource('success', 200, 'Get detail transaction', Transaction::find($id));
    }
}
