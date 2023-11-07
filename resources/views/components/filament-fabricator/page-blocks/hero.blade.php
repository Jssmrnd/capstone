@aware(['page'])
@props([
    'heading_image',
    'heading_title'
])

<section id="Content1">
    <div>
       <!-- Heading Image -->
      <img src="{{ asset("storage/site-images/".$heading_image) }}" alt="section1-image-bg" />
      <div class="tagline-text">
        <h2>{{ $heading_title }}</h2>
        <div class="buttons">
          {{-- goes to the products section --}}
          <button class="explore-button" onclick="window.location.href = '/products';">
            Explore
          </button>
          {{-- goes to the registration form --}}
          <button class="register-button" onclick="window.location.href = '/customer';">
            Register
          </button>
        </div>
      </div>
    </div>
</section>