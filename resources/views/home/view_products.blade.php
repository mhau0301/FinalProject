<!DOCTYPE html>
<html>

<head>
    @include('home.css')
</head>

<body>
  <div class="hero_area">
        @include('home.header')
  </div>
  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        
        <h2>
          Our Products
        </h2>
      </div>
      <div class="row">

        @foreach($product as $product)

        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">

            <div class="img-box">
                <img src="products/{{$product->image}}" alt="">
            </div>
            <div class="detail-box">
              <h6>{{$product->title}}</h6>
              @if($product->discount_price!=null)

                  <h6 style="color: red">
                    {{$product->discount_price}} vnd
                  </h6>     
                        
                  <h6 style="text-decoration: line-through; color: blue">
                    {{$product->price}} vnd
                  </h6>
              @else
                  <h6 style="color:blue">
                    {{$product->price}} vnd
                  </h6>
              @endif
            </div>

              <div style="padding: 10px; text-align: center;" >
                  <a class="btn btn-danger" href="{{url('product_details', $product->id)}}">Details</a>
              </div>

            </div>
        </div>

        @endforeach


      </div>

    </div>
  </section>
</body>

</html>