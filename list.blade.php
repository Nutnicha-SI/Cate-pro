@extends('layouts.main')

@section('title', $title)

@section('content')

<main>
    <form action="{{ route('products.list') }}" method="get">
        
        <div class="search">
            <label for="app-inp-search">Search ::</label>
            <input id="app-inp-search" type="text" name="term" value="{{ $term }}" />
        </div>
        <br>
        <table style="width: 100%; text-align: center;">
            <tr>
                <td>
                    <div class="price-range">
                        <label for="min-price">Min Price ::</label>
                        <input align-item="center" id="min-price" type="number" name="min_price" value="{{ $min_price }}" step="0.01" />
                        <br>
                        <br><label for="max-price">Max Price ::</label>
                        <input id="max-price" type="number" name="max_price" value="{{ $max_price }}" step="0.01" />
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <div class="button-bt">
            <button type="submit">Submit</button>
        </div>
        <br>
    </form>
    <br>
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
                <td>{{ $product['code'] }}</td> 
                <td>{{ $product['name'] }}</td>
                <td> 
                    @foreach($product['categories'] as $category) 
                        {{ $category['name'] }}&nbsp; 
                    @endforeach
                </td>
                <td class="number">{{ number_format($product['price'], 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>

@endsection
