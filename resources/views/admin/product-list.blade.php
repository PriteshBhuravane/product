<x-navbar />
<div class="container">
    <h1>Product List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->description }}</td>
                <td>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>