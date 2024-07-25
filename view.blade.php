@extends('layouts.main')

@section('title', 'Category View')

@section('content')
    <h1>Products in category: {{ $category['name'] }}</h1>

    <form method="GET" action="{{ route('categories.view', $category['code']) }}">
        <input type="text" name="term" placeholder="Search" value="{{ $term }}">
        <button type="submit">Search</button>
    </form>

    @php
        // Display all products data before foreach
        //dump($products)
        $categoryMap = ["PHP" => "CT001", "Javascript" => "CT002", "Typescript" => "CT003", "Python"=> "CT004"];

    @endphp

    <table class="app-cmp-data-list">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Categories</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            @php
                $productNameLower = strtolower($product['name']);
                $categoryNameLower = strtolower($category['name']);
                $position = strpos($productNameLower, $categoryNameLower);
            @endphp
                @if($position !== false)
                <tr>
                    <td>{{ $product['code'] ?? 'N/A' }}</td>
                    <td>{{ $product['name'] ?? 'Unknown' }}</td>
                    <td>
                        @if(is_array($product['categories']) && !empty($product['categories']))
                            @foreach($product['categories'] as $c)
                                @php
                                    $link = $categoryMap[$c['name']];
                                @endphp
                                <a href="{{ $link }}">{{ $c['name'] ?? '' }}</a>&nbsp;
                            @endforeach
                        @endif
                    </td>
                    <td class="number">{{ number_format($product['price'] ?? 0, 2) }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endsection