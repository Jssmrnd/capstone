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
            <a href="/home" class="{{ request()->is('home') ? 'active': 'hidden' }}">Home</a>
        </li>
        {{-- redirects to the products --}}
        <li>
            <a href="/products" class="{{ request()->is('products') ? 'active': 'hidden' }}">Products</a>
        </li>
        <li>
            @auth<a href="/application" class="{{ request()->is('application') ? 'active': 'hidden' }}">Application</a>@endauth
        </li>
        {{-- redirects to the about --}}
        <li>
            <a href="/about-us" class="{{ request()->is('about-us') ? 'active': 'hidden' }}">About Us</a>
        </li>
        {{-- redirects to the contact --}}
        <li>
            <a href="/contact-us" class="{{ request()->is('contact-us') ? 'active': 'hidden' }}">Contact Us</a>
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