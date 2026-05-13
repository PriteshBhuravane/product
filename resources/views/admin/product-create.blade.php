<x-navbar />

<div class="container mt-4">
    <h3>Add Product</h3>

    <p><strong>Category:</strong> {{ $category->name }}</p>

    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Save Product</button>
    </form>
</div>
