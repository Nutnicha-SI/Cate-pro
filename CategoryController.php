<?php
namespace App\Http\Controllers;

use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController extends SearchableController
{
    const ITEMS = [
        ['code' => 'CT001', 'name' => 'PHP'],
        ['code' => 'CT002', 'name' => 'Javascript'],
        ['code' => 'CT003', 'name' => 'Typescript'],
        ['code' => 'CT004', 'name' => 'Python'],
    ];

    private string $title = 'Category';

    function find(string $code): ?array
    {
        foreach (static::ITEMS as $category) {
            if ($category['code'] == $code) {
                return $category;
            }
        }
        return null;
    }

    function prepareCategory(array $items): array 
    {
        foreach ($items as $key => $item) {
            $categories = $item['categories'] ?? [];

            $preparedCategories = [];
            foreach ($categories as $catCode) {
                $category = $this->find($catCode);
                if ($category) {
                    $preparedCategories[] = $category;
                }
            }
            $items[$key]['categories'] = $preparedCategories;
        }
        return $items;
    }

    function list(ServerRequestInterface $request): View
    {
        $data = $request->getQueryParams();
        $categories = $this->search($data);

        return view('categories.list', [
            'title' => "{$this->title} : List",
            'term' => $data['term'] ?? '',
            'categories' => $categories,
        ]);
    }

    public function view(ServerRequestInterface $request, string $code): View
    {
        // Find the category based on the code
        $category = $this->find($code);
        if (!$category) {
            abort(404, 'Category not found');
        }

        // Get the search parameters
        $data = $request->getQueryParams();
        $term = $data['term'] ?? null;
        $minPrice = isset($data['min_price']) ? (float) $data['min_price'] : null;
        $maxPrice = isset($data['max_price']) ? (float) $data['max_price'] : null;

        // Fetch products based on category
        $products = $this->getProductsByCategory($code);
        $products = $this->prepareCategory($products);
        $products = $this->filterByTerm($products, $term, $minPrice, $maxPrice);

        return view('categories.view', [
            'title' => "{$this->title} : {$category['name']}",
            'term' => $term,
            'min_price' => $data['min_price'] ?? '',
            'max_price' => $data['max_price'] ?? '',
            'category' => $category,
            'products' => $products,
        ]);
    }

    // Implement this method to return products based on the category code
    private function getProductsByCategory(string $categoryCode): array
    {
        return array_filter(ProductController::ITEMS, function ($product) use ($categoryCode) {
            return in_array($categoryCode, $product['categories']);
        });
    }
}
