@aware(['page'])
@props([
    'heading_title',
])

<section id="Content1">
    <div>
       <!-- Heading Image -->
      <img src="{{ asset('images/home 2.jpg') }}" alt="section1-image-bg" />
      <div class="tagline-text">
        <h2>{{ $heading_title }}</h2>
        <div class="buttons">
          <button class="explore-button" onclick="toggleProductSection()">
            Explore
          </button>
          <button class="register-button" onclick="toggleRegisterForm()">
            Register
          </button>
        </div>
      </div>
    </div>
  </section>