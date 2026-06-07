<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->ordered()
            ->paginate(15);

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::query()->create($this->categoryDataFromRequest($request));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->loadCount('products');

        return view('categories.show', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($this->categoryDataFromRequest($request, $category));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Cannot delete a category that still has products assigned.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function categoryDataFromRequest(
        StoreCategoryRequest|UpdateCategoryRequest $request,
        ?Category $category = null,
    ): array {
        $name = $request->validated('name');

        return [
            'name' => $name,
            'slug' => $request->validated('slug'),
            'description' => $request->validated('description'),
            'sort_order' => $request->validated('sort_order'),
            'is_active' => $request->boolean('is_active', true),
        ];
    }
}
