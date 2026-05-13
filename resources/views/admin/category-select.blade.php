<x-navbar />

<div class="container mt-4">
    <h3>Select Category</h3>

    <form method="POST" action="{{ route('category.storeSelection') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Next</button>
    </form>
</div>
