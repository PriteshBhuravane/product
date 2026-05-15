<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\UserLog;
use App\Models\AdminLog;
use App\Models\CategoryLog;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // STEP 1: Show category selection
    public function selectCategory()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.category-select', compact('categories'));
    }

    // STEP 1: Store category selection in session
    public function storeCategorySelection(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        session([
            'category_id' => $request->category_id
        ]);

        return redirect()->route('product.create');
    }

    // STEP 2: Show product form
    public function create()
    {
        if (!session()->has('category_id')) {
            return redirect()->route('category.select')
                ->with('error', 'Please select category first');
        }

        $category = Category::find(session('category_id'));
        return view('admin.product-create', compact('category'));
    }

    // STEP 2: Store product
    public function store(Request $request)
    {
        if (!session()->has('category_id')) {
            return redirect()->route('category.select')
                ->with('error', 'Please select category first');
        }
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
            'description' => 'nullable',
        ]);

        //$image = $request->file('image')->store('products', 'public');
        $image = $request->file('image')->store('products', 's3');

        $product = Product::create([
            'name' => $request->name,
            'image' => $image,
            'category_id' => session('category_id'),
            'price' => $request->price,
            'description' => $request->description,
            'status' => 1,
            'created_by' => auth()->id(),
        ]);

        // Log to categorylog
        $categoryLogPath = storage_path('logs/categorylog/categorylog.txt');
        $categoryLogMsg = date('Y-m-d H:i:s') . " | Product Added: {$product->name} to Category ID: {$product->category_id} by User ID: " . auth()->id() . "\n";
        file_put_contents($categoryLogPath, $categoryLogMsg, FILE_APPEND);

        // Log to category_logs table
        CategoryLog::create([
            'user_id' => auth()->id(),
            'category_id' => $product->category_id,
            'action' => 'add_product',
            'details' => "Product Added: {$product->name}",
        ]);

        // Log to userlog
        $userLogPath = storage_path('logs/userlog/userlog.txt');
        $userLogMsg = date('Y-m-d H:i:s') . " | User Action: Added Product {$product->name} | User ID: " . auth()->id() . "\n";
        file_put_contents($userLogPath, $userLogMsg, FILE_APPEND);

        // Log to user_logs table
        UserLog::create([
            'user_id' => auth()->id(),
            'action' => 'add_product',
            'details' => "Added Product: {$product->name}",
        ]);

        // Log to adminlog if admin
        if (auth()->user() && auth()->user()->user_type === 'admin') {
            $adminLogPath = storage_path('logs/adminlog/adminlog.txt');
            $adminLogMsg = date('Y-m-d H:i:s') . " | Admin Action: Added Product {$product->name} | Admin ID: " . auth()->id() . "\n";
            file_put_contents($adminLogPath, $adminLogMsg, FILE_APPEND);
            // Log to admin_logs table
            AdminLog::create([
                'admin_id' => auth()->id(),
                'action' => 'add_product',
                'details' => "Added Product: {$product->name}",
            ]);
        }

        session()->forget('category_id');

        return redirect()->route('admin.dashboard')
            ->with('success', 'Product added successfully');
    }
    // Show all products with category name
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.product-list', compact('products'));
    }
    // Show edit form for a product
    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $productName = $product->name;
        $categoryId = $product->category_id;
        $userId = auth()->id();
        $product->delete();

        // Log to categorylog
        $categoryLogPath = storage_path('logs/categorylog/categorylog.txt');
        $categoryLogMsg = date('Y-m-d H:i:s') . " | Product Deleted: {$productName} from Category ID: {$categoryId} by User ID: {$userId}\n";
        file_put_contents($categoryLogPath, $categoryLogMsg, FILE_APPEND);

        // Log to category_logs table
        CategoryLog::create([
            'user_id' => $userId,
            'category_id' => $categoryId,
            'action' => 'delete_product',
            'details' => "Product Deleted: {$productName}",
        ]);

        // Log to userlog
        $userLogPath = storage_path('logs/userlog/userlog.txt');
        $userLogMsg = date('Y-m-d H:i:s') . " | User Action: Deleted Product {$productName} | User ID: {$userId}\n";
        file_put_contents($userLogPath, $userLogMsg, FILE_APPEND);

        // Log to user_logs table
        UserLog::create([
            'user_id' => $userId,
            'action' => 'delete_product',
            'details' => "Deleted Product: {$productName}",
        ]);

        // Log to adminlog if admin
        if (auth()->user() && auth()->user()->user_type === 'admin') {
            $adminLogPath = storage_path('logs/adminlog/adminlog.txt');
            $adminLogMsg = date('Y-m-d H:i:s') . " | Admin Action: Deleted Product {$productName} | Admin ID: {$userId}\n";
            file_put_contents($adminLogPath, $adminLogMsg, FILE_APPEND);
            // Log to admin_logs table
            AdminLog::create([
                'admin_id' => $userId,
                'action' => 'delete_product',
                'details' => "Deleted Product: {$productName}",
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
    // Update a product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $data = $request->only(['name', 'category_id', 'price', 'description']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 's3');
        }
        $product->update($data);
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }
}
