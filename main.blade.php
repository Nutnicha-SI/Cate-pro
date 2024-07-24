<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My- Controllers -@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css" />
</head>
<body>
    <header id="app-cmp-main-header">
  <h1>My-controllers @section('title-container') @yield('title')@show </h1>
  <nav>
    <ul>
        <li>
           <a href="{{ route('products.list')}}">Products</a>
        </li>
        <li>
            <a href="{{ route('categories.list')}}">Categories</a>
         </li>
    </ul>
  </nav>
       
    </header> 
    <div id="app-cmp-main-content">
    @yield('content')
        </div>
    <footer class="footer">
        <br>
        Week-06: Controller , Nutnicha
    </footer>
</body>
</html>