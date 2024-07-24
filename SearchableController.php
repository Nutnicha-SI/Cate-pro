<?php

namespace App\Http\Controllers;

class SearchableController extends Controller
{
    const ITEMS = [];

    function filterByTerm(array $items, ?string $term, ?float $minPrice, ?float $maxPrice): array 
    {
        $results = [];
        foreach ($items as $item) {
            $term = trim($term ?? '');
            $price = $item['price'] ?? null;
    
            // ตรวจสอบเงื่อนไขการค้นหา
            if (
                ($term === '' || stripos($item['name'], $term) !== false || stripos($item['code'], $term) !== false || (isset($item['categories']) && is_array($item['categories']) && in_array($term, $item['categories']))) &&
                ($price === null || (($minPrice === null || $price >= $minPrice) && ($maxPrice === null || $price <= $maxPrice)))
            ) {
                $results[] = $item;
            }
        }
        return $results;
    }
    
    function search(array $data): array {
        $term = $data['term'] ?? null;
        $minPrice = isset($data['min_price']) ? (float)$data['min_price'] : null;
        $maxPrice = isset($data['max_price']) ? (float)$data['max_price'] : null;
        $items = static::ITEMS;
        if ($term !== null || $minPrice !== null || $maxPrice !== null) {
            $items = $this->filterByTerm($items, $term, $minPrice, $maxPrice);
        }
        return $items;
    }
}
