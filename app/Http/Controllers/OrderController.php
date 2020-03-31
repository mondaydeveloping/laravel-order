<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Order;
use App\Book;
use App\User;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $status = $request->get('status');
        $buyer_email = $request->get('buyer_email');
        $orders = \App\Order::with('user')->with('books')
        ->whereHas('user', function($query) use ($buyer_email) {
        $query->where('email', 'LIKE', "%$buyer_email%");
        })
        ->where('status', 'LIKE', "%$status%")
        ->paginate(10);
        return view('orders.index', ['orders' => $orders]);
    }
    public function checkout()
    {
        return view('orders.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::all();
        // dd($books);
        $users = User::pluck('id','name');
        // dd($users);
        $orders = Order::all();
        
        return view('orders.create', ['books' => $books],['users'=>$users], ['orders' => $orders]);
        //return view('orders.create', compact('books','orders','users'));
    }
 


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){
    //     $order = new \App\Order;
    //     $order->title = $request->get('title');
    //     $order->description = $request->get('description');
    //     $order->author = $request->get('author');
    //     $order->publisher = $request->get('publisher');
    //     $order->price = $request->get('price');
    //     $order->stock = $request->get('stock');

    //     $order->status = $request->get('save_action');

    //     $cover = $request->file('cover');

    //     if ($cover) {
    //         $cover_path = $cover->store('book-covers', 'public');

    //         $order->cover = $cover_path;
    //     }
    //     $order->slug = \Str::slug($request->get('title'));

    //     $order->created_by = \Auth::user()->id;

    //     $order->save();

    //     $order->categories()->attach($request->get('categories'));

    //     if ($request->get('save_action') == 'PUBLISH') {
    //         return redirect()
    //             ->route('books.create')
    //             ->with('status', 'Book successfully saved and published');
    //     } else {
    //         return redirect()
    //             ->route('books.create')
    //             ->with('status', 'Book saved as draft');
    //     }
    // }

    }
                        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = \App\Order::findOrFail($id);

        return view('orders.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $order = \App\Order::findOrFail($id);
        $order->status = $request->get('status');
        $order->save();
        return redirect()->route('orders.edit', [$order->id])->with('status',
        'Order status succesfully updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
