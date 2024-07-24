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
        dump($products);
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
                <tr>
                    <td>{{ $product['code'] ?? 'N/A' }}</td>
                    <td>{{ $product['name'] ?? 'Unknown' }}</td>
                    <td>
                        @if(is_array($product['categories']) && !empty($product['categories']))
                            @foreach($product['categories'] as $category)
                                {{ $category['name'] ?? '' }}&nbsp;
                            @endforeach
                        @endif
                    </td>
                    <td class="number">{{ number_format($product['price'] ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
๓