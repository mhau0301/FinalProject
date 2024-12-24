<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include('home.css')
</head>
<body>
        @include('home.header')
    @section('content')
    <div class="container mt-4">
        <h4>Search Results for: "{{ $query }}"</h4>

        @if($product->count() > 0)
            <div class="row">
                @foreach($product as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="/products/{{ $product->image }}" alt="{{ $product->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <a href="{{ url('product/' . $product->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <p>No products found for "{{ $query }}".</p>
        @endif
    </div>
    @endsection

</body>
</html>
