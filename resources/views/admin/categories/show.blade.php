<h1>{{ $category->name }}</h1>

<div class="products">
    @foreach($products as $product)
        <div class="product-card">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            @endif
            <h2>{{ $product->name }}</h2>
            <p>Rp {{ number_format($product->price,0,',','.') }}</p>
            <p>Stock: {{ $product->stock ?? '-' }}</p>
        </div>
    @endforeach
</div>
