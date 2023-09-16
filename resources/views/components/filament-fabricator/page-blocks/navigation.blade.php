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

<header class="text-gray-600 body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
      <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
        <span class="ml-3 text-xl">{{ $company_name }}</span>
      </a>
      <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
        <a class="mr-5 hover:text-gray-900" href="/home">Home</a>
        <a class="mr-5 hover:text-gray-900" href="/products">Products</a>
        @auth
            <a class="mr-5 hover:text-gray-900" href="/application">Application</a>
        @endauth
        <a class="mr-5 hover:text-gray-900" href="/contact-us">Contact Us</a>
        <a class="mr-5 hover:text-gray-900" href="/about-us">About Us</a>
      </nav>
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href= "{{ route('logout') }}" class="mr-5 hover:text-gray-900">Logout</a>
                @else
                    <a href="{{ route('login') }}" class="mr-5 hover:text-gray-900">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="mr-5 hover:text-gray-900">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
  </header>