@aware(['page'])
@props([
    'heading_title',
    'heading_description',
])
<div class="px-4 py-4 md:py-8">
    <div class="max-w-7xl mx-auto">
        <section class="text-gray-400 bg-gray-900 body-font">
            <div class="container mx-auto flex px-5 py-24 items-center justify-center flex-col">
            <div class="text-center lg:w-2/3 w-full">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-white">{{ $heading_title }}</h1>
            <p class="leading-relaxed mb-8">{{ $heading_description }}</p>
            <div class="flex justify-center">
                {{-- <button class="inline-flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded text-lg">Button</button>
                <button class="ml-4 inline-flex text-gray-400 bg-gray-800 border-0 py-2 px-6 focus:outline-none hover:bg-gray-700 hover:text-white rounded text-lg">Button</button> --}}
            </div>
            </div>
        </div>
        </section>
    </div>
</div>
