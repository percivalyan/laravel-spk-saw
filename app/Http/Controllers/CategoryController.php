<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        $data['PermissionAdd'] = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        $data['PermissionEdit'] = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        $data['PermissionDelete'] = PermissionRole::getPermission('Delete Category', Auth::user()->role_id);
        $data['PermissionShow'] = PermissionRole::getPermission('Show Category', Auth::user()->role_id);

        $categories = Category::query();

        if ($request->has('search') && $request->search != '') {
            $categories->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code_category', 'like', '%' . $request->search . '%');
            });
        }

        $categories = $categories->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('panel.categories.index', compact('categories'), $data);
    }

    public function create()
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        return view('panel.categories.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->code_category = Str::random(11);  // Generate random code with 11 characters
        $category->description = $request->description;
        $category->user_id = Auth::id();
        $category->role_id = Auth::user()->role_id;

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        return view('panel.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Delete Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        $category->deleted_by = Auth::id();
        $category->save();
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category successfully deleted.');
    }

    public function show($id)
    {
        if (!Auth::check()) abort(403);

        $PermissionCategory = PermissionRole::getPermission('Show Category', Auth::user()->role_id);
        if (empty($PermissionCategory)) abort(404);

        $category = Category::with('user', 'role')->findOrFail($id);

        return view('panel.categories.show', compact('category'));
    }
}
