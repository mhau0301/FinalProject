<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;

use App\Mail\ContactFormMail;

use Illuminate\Support\Facades\Mail;

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

    public function confirm_order(Request $request)
    {
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $days = $request->days; // Nhận giá trị 'days' từ request
    
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect('login')->with('message', 'Please log in to confirm your order.');
        }
    
        $userid = Auth::id();
        $cart = Cart::where('user_id', $userid)->get();
    
        if ($cart->isEmpty()) {
            return redirect()->back()->with('message', 'Your cart is empty. Please add items before placing an order.');
        }
    
        // Tính tổng giá trị đơn hàng
        $totalOrderValue = 0;
    
        foreach ($cart as $carts) {
            $product = Product::find($carts->product_id);
    
            if (!$product) {
                continue; // Bỏ qua nếu sản phẩm không tồn tại
            }
    
            // Kiểm tra số lượng trong kho
            if ($product->quantity < $carts->quantity) {
                return redirect()->back()->with('error', "Not enough stock for product: {$product->name}");
            }
    
            // Tính giá trị sản phẩm theo số lượng và ngày thuê
            $productValue = $product->price * $carts->quantity * $days;
            $totalOrderValue += $productValue;
    
            // Tạo đơn hàng mới cho từng sản phẩm
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $product->id;
            $order->quantity = $carts->quantity;
            $order->days = $days; // Lưu số ngày thuê
            $order->status = 'in progress'; // Đặt trạng thái ban đầu
            $order->save();
    
            // Cập nhật số lượng sản phẩm trong kho
            $product->quantity -= $carts->quantity;
            $product->status = $product->quantity > 0 ? 'available' : 'out_of_stock';
            $product->save();
        }
    
        // Cập nhật tổng giá trị đơn hàng vào bảng Order
        foreach ($cart as $carts) {
            $order = Order::where('user_id', $userid)->latest()->first();
            $order->total_value = $totalOrderValue; // Lưu tổng giá trị của đơn hàng
            $order->save();
        }
    
        // Xóa tất cả sản phẩm trong giỏ hàng sau khi đặt hàng
        Cart::where('user_id', $userid)->delete();
    
        return redirect()->back()->with('message', 'Order placed successfully!');
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

    public function updateQuantity(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        // Cập nhật số lượng
        $product->quantity = $request->input('quantity');
        $product->save(); // Eloquent tự động cập nhật `status`

        return back()->with('message', 'Product updated successfully! Status: ' . $product->status);
    }

    public function cancelOrder($orderId)
    {
        // Lấy đơn hàng từ cơ sở dữ liệu
        $order = Order::find($orderId);
    
        if ($order && !in_array($order->status, ['On the Way', 'Delivered', 'Canceled'])) {
            // Lấy sản phẩm liên quan đến đơn hàng
            $product = $order->product;
    
            if ($product) {
                // Tăng số lượng sản phẩm trở lại
                $product->quantity += $order->quantity; // assuming $order->quantity is the amount ordered
                $product->save();
            }
    
            // Cập nhật trạng thái đơn hàng thành 'canceled'
            $order->status = 'Canceled';
            $order->save();
    
            // Chuyển hướng về trang danh sách đơn hàng
            return redirect()->route('myOrders')->with('message', 'Đơn hàng đã được hủy thành công.');
        }
    }

    public function returned($orderId)
    {
        // Lấy đơn hàng từ cơ sở dữ liệu
        $order = Order::find($orderId);
    
        // Kiểm tra đơn hàng và trạng thái hợp lệ
        if ($order && $order->status === 'Delivered') {
            // Lấy sản phẩm liên quan đến đơn hàng
            $product = $order->product;
    
            if ($product && is_numeric($order->quantity) && $order->quantity > 0) {
                // Tăng số lượng sản phẩm trở lại
                $product->quantity += $order->quantity;
                $product->save();
            }
    
            // Cập nhật trạng thái đơn hàng thành 'Returned'
            $order->status = 'Returned';
    
            if ($order->save()) {
                // Chuyển hướng về trang danh sách đơn hàng
                return redirect()->route('myOrders')->with('message', 'Xe đã được trả thành công.');
            } 
        }
    }
    

    public function markAsDelivered($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->status = 'Delivered';
            $order->save();
    
            return redirect()->back()->with('message', 'Đơn hàng đã được cập nhật sang trạng thái "Đã nhận được hàng".');
        }
    
        return redirect()->back()->with('message', 'Không tìm thấy đơn hàng.');
    }    
    
    public function onTheWay($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('message', 'Đơn hàng không tồn tại.');
        }

        $order->status = 'On the Way';
        $order->save();

        return redirect()->back()->with('message', 'Đơn hàng đã được chuyển sang trạng thái "Đang vận chuyển".');
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa
        if (!$query) {
            return back()->with('error', 'Please enter a search term.');
        }
    
        $product = Product::where('title', 'LIKE', '%' . $query . '%')
                            ->orWhere('description', 'LIKE', '%' . $query . '%')
                            ->paginate(10);
    
        return view('home.search_results', compact('product', 'query'));
    }
    
    
}