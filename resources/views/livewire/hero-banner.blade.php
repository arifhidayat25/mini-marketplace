<div x-data="{
    init() {
        new Swiper(this.$refs.swiper, {
            loop: true,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
}" x-init="init()" class="relative">

    <div x-ref="swiper" class="swiper h-64 md:h-96 rounded-lg">
        <div class="swiper-wrapper">
            @forelse($banners as $banner)
            <div class="swiper-slide">
                <a href="{{ $banner->link_url ?? '#' }}" class="block w-full h-full">
                    <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover" />
                </a>
            </div>
            @empty
            <div class="swiper-slide">
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <p class="text-gray-500">No active banners</p>
                </div>
            </div>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev text-white"></div>
        <div class="swiper-button-next text-white"></div>
    </div>

</div>