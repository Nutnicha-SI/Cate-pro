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
        
        // Fetch products based on category
        $products = $this->getProductsByCategory($code);

        // Prepare the category view with search functionality
        return view('categories.view', [
            'title' => "{$this->title} : {$category['name']}",
            'term' => $data['term'] ?? '',
            'category' => $category,
            'products' => $products,
        ]);
    }

        // Implement this method to return products based on the category code
        // For demonstration, returning dummy products
        private function getProductsByCategory(string $categoryCode): array
        {
            return ProductController::ITEMS; // This can be updated to fetch products based on the category code.
        }
    }

