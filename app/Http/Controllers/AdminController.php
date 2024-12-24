<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Order;

use App\Models\Product;


class AdminController extends Controller
{
    public function view_category() {
        $data=Category::all();

        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request) {

        $data=new category;
        $data->category_name=$request->category;
        $data->save();
        return redirect()->back()->with('message', 'Category Added Successfully!');
    }

    public function delete_category($id) {
        $data = Category::find($id);
        $data->delete();
        return redirect()->back();
    }

    public function edit_category($id) {
        $data = Category::find($id);
        return view('admin.edit_category',compact('data'));
    }

    public function update_category(Request $request, $id) {
        $data = Category::find($id);
        $data->category_name=$request->category;
        $data->save();
        
        return redirect('/view_category')->with('message', 'Category Updated Successfully!');
    }

    public function add_product() {
        $category=Category::all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request) {
        $data = new Product;
        $data->title=$request->title;
        $data->description=$request->description;
        $data->price=$request->price;
        $data->discount_price=$request->discount_price;
        $data->quantity=$request->quantity;
        $data->category=$request->category;

        $image=$request->image;

        if($image) {
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
            $data->image=$imagename;
        }

        $data->save();
        return redirect()->back()->with('message', 'Product Added Successfully!');

    }

    public function view_product() {
        $product = Product::all();
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id) {
        $product=product::find($id);
        $product->delete();
        return redirect()->back()->with('message','Product Deleted Successfully!');
    }

    public function update_product($id){
        $product=product::find($id);
        $category=category::all();
        return view('admin.update_product',compact('product','category'));
    }

    public function update_product_confirm(Request $request,$id) {
        $product=product::find($id);
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->discount_price=$request->discount_price;
        $product->category=$request->category;
        $product->quantity=$request->quantity;

        $image=$request->image;

        if($image)
        {
            $imagename=time().'.'.$image->getClientOriginalExtension();

            $request->image->move('product',$imagename);
    
            $product->image=$imagename;
        }
        
        $product->save();
        return redirect()->back()->with('message','Product Updated Successfully!');

    }
    
    public function product_search(Request $request){
        $search = $request->search;
        $product = Product::where('title','LIKE','%'.$search.'%')->paginate(3);
        return view('admin.view_product',compact('product'));
    }

    public function view_orders() {
        $data = Order::with('product')->get(); // Lấy tất cả các đơn hàng cùng với thông tin sản phẩm
        return view('admin.order', compact('data'));
    }


    public function on_the_way($id){
        $data=Order::find($id);
        $data->status = 'On the Way';
        $data->save();
        return redirect('/view_orders');
    }

    public function delivered($id){
        $data=Order::find($id);
        $data->status = 'Delivered';
        $data->save();
        return redirect('/view_orders');
    }

    public function in_progress($id){
        $data=Order::find($id);
        $data->status = 'In Progress';
        $data->save();
        return redirect('/view_orders');
    }
    
    public function canceled($id)
    {
        // Lấy thông tin đơn hàng
        $order = Order::find($id);
    
        // Kiểm tra nếu đơn hàng không tồn tại
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        // Cập nhật trạng thái đơn hàng thành 'Canceled'
        $order->status = 'Canceled';
    
        // Tăng số lượng sản phẩm trong kho nếu có sản phẩm liên quan
        if ($order->product) {
            $order->product->quantity += $order->quantity; // Số lượng trong đơn hàng được cộng lại vào kho
            $order->product->save();
        }
    
        // Lưu lại đơn hàng
        $order->save();
    
        // Điều hướng về trang admin quản lý đơn hàng với thông báo
        return redirect()->back()->with('message', 'Order has been canceled successfully, and product stock has been updated.');
    }
    

    public function returned($id)
    {
        // Lấy thông tin đơn hàng
        $order = Order::find($id);
    
        // Cập nhật trạng thái đơn hàng thành 'Canceled'
        $order->status = 'Returned';
    
        // Tăng số lượng sản phẩm trong kho nếu có sản phẩm liên quan
        if ($order->product) {
            $order->product->quantity += $order->quantity; // Số lượng trong đơn hàng được cộng lại vào kho
            $order->product->save();
        }
    
        // Lưu lại đơn hàng
        $order->save();
    
        // Điều hướng về trang admin quản lý đơn hàng với thông báo
        return redirect()->back()->with('message', 'Returned successfully, and product stock has been updated.');
    }

    public function filterProducts($category)
    {
        if ($category === 'all') {
            $product = Product::all();
        } else {
            $product = Product::where('category', $category)->get();
        }

        return view('admin.view_product', compact('product'));
    }

    

}