<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class Order1Controller extends Controller
{
    public function addOrder()
    {
        $books = Book::orderBy('created_at', 'DESC')->get();
        return view('orders.add', compact('books'));
    }

    public function getProduct($id)
    {
        $books = Book::findOrFail($id);
        return response()->json($books, 200);
    }

    public function addToCart(Request $request)
    {
        //validasi data yang diterima
        //dari ajax request addToCart mengirimkan id dan qty
        $this->validate($request, [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer'
        ]); 

        //mengambil data product berdasarkan id
        $book = Book::findOrFail($request->book_id);
        //mengambil cookie cart dengan $request->cookie('cart')
        $getCart = json_decode($request->cookie('cart'), true);
        
        //jika datanya ada     
        if ($getCart) {
            //jika key nya exists berdasarkan product_id
            if (array_key_exists($request->book_id, $getCart)) {
                //jumlahkan qty barangnya
                $getCart[$request->book_id]['quantity'] += $request->quantity;
                //dikirim kembali untuk disimpan ke cookie
                return response()->json($getCart, 200)->cookie('cart', json_encode($getCart), 120);
            }
        }

        //jika cart kosong, maka tambahkan cart baru
        $getCart[$request->book_id] = [
            'invoice_number' => $book->invoice_number,
            'title' => $book->title,
            'price' => $book->price,
            'quantity' => $request->quantity
        ];

        //kirim responsenya kemudian simpan ke cookie
        return response()->json($getCart, 200)->cookie('cart', json_encode($getCart), 120);
    }

    public function getCart()
    {
        //mengambil cart dari cookie
        $cart = json_decode(request()->cookie('cart'), true);
        //mengirimkan kembali dalam bentuk json untuk ditampilkan dengan vuejs
        return response()->json($cart, 200);
    }
    
    public function removeCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);
        //menghapus cart berdasarkan product_id
        unset($cart[$id]);
        //cart diperbaharui
        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
    }
}
