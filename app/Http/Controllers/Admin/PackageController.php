<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(10);
        return view('admin.packages.all', compact('packages'));
    }
    public function create()
    {
        return view('admin.packages.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'code' => 'nullable|string|max:255', 'price' => 'nullable|numeric', 'joining_amount' => 'nullable|numeric', 'renewal_amount' => 'nullable|numeric', 'short_description' => 'nullable|string|max:255', 'description' => 'nullable|string', 'image' => 'nullable|image', 'icon' => 'nullable|image', 'is_popular' => 'nullable', 'is_featured' => 'nullable', 'sort_order' => 'nullable|integer', 'status' => 'nullable',]);
        $data['slug'] = Str::slug($request->name);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('packages/icons', 'public');
        }
        $data['is_popular'] = $request->has('is_popular');
        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = $request->has('status');
        Package::create($data);
        return redirect()->route('packages.all')->with('success', 'Package created successfully.');
    }
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }
    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }
    public function update(Request $request, Package $package)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'code' => 'nullable|string|max:255', 'price' => 'nullable|numeric', 'joining_amount' => 'nullable|numeric', 'renewal_amount' => 'nullable|numeric', 'short_description' => 'nullable|string|max:255', 'description' => 'nullable|string', 'image' => 'nullable|image', 'icon' => 'nullable|image', 'sort_order' => 'nullable|integer',]);
        $data['slug'] = Str::slug($request->name);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('packages/icons', 'public');
        }
        $data['is_popular'] = $request->has('is_popular');
        $data['is_featured'] = $request->has('is_featured');
        $data['status'] = $request->has('status');
        $package->update($data);
        return redirect()->route('packages.all')->with('success', 'Package updated successfully.');
    }
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.all')->with('success', 'Package deleted successfully.');
    }
}