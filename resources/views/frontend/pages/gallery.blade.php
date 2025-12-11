@extends('frontend.layouts.master')

@section('title','Thangka Store')

@section('main-content')


<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{ url('/') }}">Home<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="#">Gallery</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<section id="gallery" class="gallery-section">
    <h2>Gallery</h2>
    
    <div id="crochet-gallery" class="gallery-container">

        <!-- Replace these images with your own -->
        @for ($i = 1; $i <= 12; $i++)
            <a href="/images/{{ $i }}.jpg" data-lg-size="1600-2400" data-sub-html="<h4>Handmade Crochet</h4>">
                <img src="/images/{{ $i }}.jpg" alt="Crochet Item {{ $i }}">
            </a>
        @endfor
        
    </div>

</section>

<!-- Start Shop Services Area -->
<section class="shop-services section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-rocket"></i>
					<h4>Free Shipping</h4>
					<p>On orders over $100</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-reload"></i>
					<h4>Free Return</h4>
					<p>Within 30 days</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-lock"></i>
					<h4>Secure Payment</h4>
					<p>100% secure payment</p>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-tag"></i>
					<h4>Best Price</h4>
					<p>Guaranteed price</p>
				</div>
			</div>

		</div>
	</div>
</section>
<!-- End Shop Services Area -->

@include('frontend.layouts.newsletter')

@push('scripts')

<!-- LightGallery JS -->
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/lightgallery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/thumbnail/lg-thumbnail.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/plugins/zoom/lg-zoom.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const galleryContainer = document.getElementById('crochet-gallery');

    if (galleryContainer) {
        lightGallery(galleryContainer, {
            selector: 'a',
            plugins: [lgThumbnail, lgZoom],
            mode: 'lg-fade',
            speed: 500,
            download: false,
            loop: true,
            thumbnail: true,
            zoom: true,
            fullScreen: true,
        });
    }
});
</script>
@endpush


@endsection
