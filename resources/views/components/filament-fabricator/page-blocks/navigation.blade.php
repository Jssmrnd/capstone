@aware(['page'])
@props([
    'company_name',
])

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
            <a href="/about-us">About Us</a>
        </li>
        {{-- redirects to the contact --}}
        <li>
            <a href="/contact-us">Contact Us</a>
        </li>
    </ul>
    <!-- User registration and menu icon -->
    <div class="main">
        <a href="/customer" class="user" id="loginLink">Log In 
            <i class="ri-account-circle-fill"></i>
        </a>
        <div class="ri-menu-line" id="menu-icon"></div>
    </div>
</header>