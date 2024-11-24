<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index() {
        $user=User::where('usertype','user')->get()->count(); 
        $product = Product::all()->count();
        $order=Order::all()->count();
        $delivered=Order::where('status','Delivered')->get()->count();
        return view('admin.index',compact('user','product','order','delivered'));
    }

    public function home() {
        $product=Product::all();
        if(Auth::id()){
            $user=Auth::user();
            $userid = $user->id;
            $count=Cart::where('user_id',$userid)->count();
        }
        else {
            $count='';
        }
        
        return view('home.index', compact('product','count'));
    }

    public function login_home() {
        $product=Product::all();
        if(Auth::id()){
            $user=Auth::user();
            $userid = $user->id;
            $count=Cart::where('user_id',$userid)->count();
        }
        else {
            $count='';
        }
        return view('home.index', compact('product','count'));
    }
    public function product_details($id) {
        $data = Product::find($id);
        if(Auth::id()){
            $user=Auth::user();
            $userid = $user->id;
            $count=Cart::where('user_id',$userid)->count();
        }
        else {
            $count='';
        }
        return view('home.product_details',compact('data','count'));
    }
    public function add_cart($id) {
        $product_id = $id;
    
        // Lấy thông tin user đã đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
    
            // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
            $cartItem = Cart::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->first();
    
            if ($cartItem) {
                // Nếu sản phẩm đã có, tăng số lượng
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                // Nếu sản phẩm chưa có, thêm mới
                $data = new Cart;
                $data->user_id = $user_id;
                $data->product_id = $product_id;
                $data->quantity = 1; // Thêm số lượng mặc định là 1
                $data->save();
            }
    
            return redirect()->back()->with('message', 'Product added to the cart successfully!');
        }
    
        return redirect('login')->with('message', 'Please log in to add products to the cart.');
    }
    

    public function mycart() {
        if(Auth::id()){
            $user=Auth::user();
            $userid = $user->id;
            $count=Cart::where('user_id',$userid)->count();

            $cart=Cart::where('user_id',$userid)->get();
        }

        return view('home.mycart', compact('count','cart'));
    }

    public function remove_cart($id) {
        $cart=cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function confirm_order(Request $request){
        $name=$request->name;
        $address=$request->address;
        $phone=$request->phone;
        $userid=Auth::user()->id;
        $cart=Cart::where('user_id',$userid)->get();

        foreach($cart as $carts) {
            $order= new Order;
            $order->name=$name;
            $order->rec_address=$address;
            $order->phone=$phone;
            $order->user_id=$userid;
            $order->product_id=$carts->product_id;
            $order->save();
        }

        $cart_remove = Cart::where('user_id',$userid)->get();

        foreach($cart_remove as $remove) {
            $data=Cart::find($remove->id);
            $data->delete();
        }
        return redirect()->back()->with('message', 'Order successfully!');
    }

    public function myorders() {
        $user=Auth::user()->id;
        $count=Cart::where('user_id',$user)->get()->count();
        $order = Order::where('user_id',$user)->get();
        return view('home.order',compact('count','order'));
    }
    
    public function view_products()
    {
        $product = Product::all();
        $count = Product::count();
        return view('home.view_products', compact('product', 'count'));
    }

    public function why() {
        $product = Product::all();
        $count = Product::count();
        return view('home.why', compact('product', 'count'));
    }

    public function contact() {
        $product = Product::all();
        $count = Product::count();
        return view('home.contact',compact('count','product'));
    }

    public function testimonial() {
        $product = Product::all();
        $count = Product::count();
        return view('home.testimonial',compact('count','product'));
    }
}