<?php

namespace App\Http\Controllers\PortalAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortalCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with(['children' => fn ($q) => $q->withCount('listings')])
            ->withCount('listings')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('portal-admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $category = Category::create($validated);
        AuditLog::record('portal.category_created', Category::class, $category->id, ['name' => $category->name]);

        return back()->with('success', "Category '{$category->name}' created successfully.");
    }
}
