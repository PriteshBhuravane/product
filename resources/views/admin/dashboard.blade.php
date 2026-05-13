<x-navbar />
<div class="container mt-4">
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Product Image"
                    style="height:200px;object-fit:cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Category: {{ $product->category ? $product->category->name
                        : '-' }}</h6>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text fw-bold">Price: ${{ $product->price }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
