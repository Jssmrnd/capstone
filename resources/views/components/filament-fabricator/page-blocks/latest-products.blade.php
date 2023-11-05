@aware(['page'])
@props([
    'product_list',
])
<section id="Content3">
    <div class="heading">
      <h1 class="Title"> Introducing the Latest Arrival to Our Motorcycle Lineup! </h1>
    </div>
    <div class="home-product-row"> @foreach ($product_list as $product) 
      <div class="home-product-col">
        <img src="{{ $product->getMedia('product-images')->first()->getUrl() }}" alt="" />
        <h2 class="testi-name">{{ $product->model_name }}</h2>
        <div class="c3-buttons">
          <a href="/products/product-specs/{{$product->id}}">View Full Specs</a>
        </div>
      </div> @endforeach </div>
    <div class="c3-buttons">
      <a href="../html/products.html">See More</a>
    </div>
  </section>