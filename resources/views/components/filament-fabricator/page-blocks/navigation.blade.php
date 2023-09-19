@aware(['page'])
@props([
    'company_name',
])
{{-- <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
@if (isset($navbar_links))
    @foreach ($navbar_links as $link)
        <div class="lg:w-1/4 md:w-1/2 p-4 w-full">

        </div>
    @endforeach
@endif --}}

{{-- <header>
    <a href="../html/index.html" class="logo">BrandName</a>
        <a class="" href="/home">Home</a>
        <a class="mr-5 hover:text-gray-900" href="/products">Products</a>
            @auth
                <a class="mr-5 hover:text-gray-900" href="/application">Application</a>
            @endauth
            <a class="mr-5 hover:text-gray-900" href="/contact-us">Contact Us</a>
            <a class="mr-5 hover:text-gray-900" href="/about-us">About Us</a>
        @if (Route::has('login'))
            @auth
                <a href= "{{ route('logout') }}" class="mr-5 hover:text-gray-900">Logout</a>
        @else
                <a href="{{ route('login') }}" class="mr-5 hover:text-gray-900">Log in</a>
                @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mr-5 hover:text-gray-900">Register</a>
                @endif
            @endauth
        @endif
    </div>
  </header> --}}


  <header>
    <!-- Brand logo Text -->
    <a href="#" class="logo">{{ $company_name }}</a>
    <!-- Navigation bar -->
    <ul class="navbar">
        {{-- redirects to the home --}}
        <li>
            <a href="/home" class="active">Home</a>
        </li>
        {{-- redirects to the products --}}
        <li>
            <a href="/products" >Products</a>
        </li>
        <li>
            @auth<a href="/application">Application</a>@endauth
        </li>
        {{-- redirects to the about --}}
        <li>
            <a href="/about">About</a>
        </li>
        {{-- redirects to the contact --}}
        <li>
            <a href="/contact-us">Contact Us</a>
        </li>
    </ul>
    <!-- User registration and menu icon -->
    <div class="main">
        <a href="/login" class="user" id="loginLink">Log In 
            <i class="ri-account-circle-fill"></i>
        </a>
        <div class="ri-menu-line" id="menu-icon"></div>
    </div>
</header>