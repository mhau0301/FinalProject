<!DOCTYPE html>
<html>
  <head> 
    @include('admin/css')
    <style type="text/css">
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 30px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            color: black;
        }

        .form-group label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: blue;
        }

        .form-actions {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-primary:hover,
        .btn-danger:hover {
            opacity: 0.9;
        }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
          @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }}
        </div>
        @endif

        <div class="form-container">
            <h1>Update Product</h1>

            <form action="{{ url('/update_product_confirm', $product->id)}}" method="POST" enctype="multipart/form-data">

                @csrf

                <!-- Product Title -->
                <div class="form-group">
                    <label for="title">Product Title</label>
                    <input type="text" id="title" name="title" value="{{$product->title}}">
                </div>

                <!-- Product Description -->
                <div class="form-group">
                    <label for="description">Product Description</label>
                    <input type="text" id="description" name="description" value="{{$product->description}}">
                </div>

                <!-- Product Price -->
                <div class="form-group">
                    <label for="price">Product Price</label>
                    <input type="number" id="price" name="price" min="0" value="{{$product->price}}">
                </div>

                <!-- Discount Price -->
                <div class="form-group">
                    <label for="discount_price">Discount Price</label>
                    <input type="number" id="discount_price" name="discount_price" min="0" value="{{$product->discount_price}}">
                </div>

                <!-- Product Quantity -->
                <div class="form-group">
                    <label for="quantity">Product Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="0"value="{{$product->quantity}}">
                </div>

                <!-- Product Category -->
                <div class="form-group">
                    <label for="category">Product Category</label>
                    <select id="category" name="category" >
                        <option value="{{$product->category}}" selected="">{{$product->category}}</option>

                        @foreach($category as $category)
                        <option value="{{ $category->category_name }}">{{ $category->category_name }}</option>
                        @endforeach
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Current Product Image</label>
                    <img height="100" width="100" src="/products/{{$product->image}}" alt="">
                </div>

                <!-- Product Image -->
                <div class="form-group">
                    <label for="image">Change Product Image</label>
                    <input type="file" id="image" name="image">
                </div>

                <!-- Submit Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
      </div>
    </div>
    @include('admin.js')

   
  </body>
</html>