<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-20">
            <h2 class="text-2xl font-medium title-font mb-4 text-gray-900 tracking-widest">{{ $title }}</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">{{ $subtitle }}</p>
        </div>
            <div class="flex flex-wrap -m-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>