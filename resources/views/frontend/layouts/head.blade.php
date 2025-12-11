<!-- Meta Tag -->
@yield('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Title Tag  -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="icon" type="image/png" href="{{asset('frontend/img/favicon.png')}}">
<!-- Web Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

<!-- StyleSheet -->

<link rel="manifest" href="/manifest.json">

<!-- LightGallery CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.2/css/lightgallery-bundle.min.css" />


<!-- Bootstrap -->
<link rel="stylesheet" href="{{asset('frontend/css/bootstrap.css')}}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Magnific Popup -->
<link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.min.css')}}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('frontend/css/font-awesome.css')}}">
<!-- Fancybox -->
<link rel="stylesheet" href="{{asset('frontend/css/jquery.fancybox.min.css')}}">
<!-- Themify Icons -->
<link rel="stylesheet" href="{{asset('frontend/css/themify-icons.css')}}">
<!-- Nice Select CSS -->
<link rel="stylesheet" href="{{asset('frontend/css/niceselect.css')}}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">
<!-- Flex Slider CSS -->
<link rel="stylesheet" href="{{asset('frontend/css/flex-slider.min.css')}}">
<!-- Owl Carousel -->
<link rel="stylesheet" href="{{asset('frontend/css/owl-carousel.css')}}">
<!-- Slicknav -->
<link rel="stylesheet" href="{{asset('frontend/css/slicknav.min.css')}}">
<!-- Jquery Ui -->
<link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.css')}}">

<!-- Eshop StyleSheet -->
<link rel="stylesheet" href="{{asset('frontend/css/reset.css')}}">
<link rel="stylesheet" href="{{asset('frontend/css/style.css?v=1.4')}}">
<link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
<!-- <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script> -->
<style>
    /* Multilevel dropdown */
    .dropdown-submenu {
    position: relative;
    }

    .dropdown-submenu>a:after {
    content: "\f0da";
    float: right;
    border: none;
    font-family: 'FontAwesome';
    }

    .dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: 0px;
    margin-left: 0px;
    }

    /* Caption styling */
.lg-sub-html h4 {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 8px 0 0;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.7);
}

/* Dark overlay aesthetic */
.lg-backdrop {
    background: rgba(0,0,0,0.92);
}

/* Thumbnail rounded corners */
.lg-thumb-item img {
    border-radius: 8px;
}

/* Remove ugly outline box from active thumbnail */
.lg-thumb-item.active {
    border: 3px solid #f1c7d7;   /* pastel pink highlight */
    border-radius: 8px;
}


/* --- Sections & Layout --- */
.gallery-section,
.shop-services {
    padding: 80px 5%;
    max-width: 1200px;
    margin: 0 auto;
}

footer {
    padding: 20px 0 !important;
}


h2 {
    text-align: center;
    font-size: 2.5em;
    margin-bottom: 50px;
}

/* --- Gallery Section (LightGallery Grid) --- */
.gallery-section {
    background-color: var(--light-bg);
}

.gallery-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.gallery-container a {
    display: block;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    line-height: 0;
    background: white;
}

.gallery-container img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: transform 0.4s ease-in-out;
}

.gallery-container img:hover {
    transform: scale(1.08);
    opacity: 0.95;
}

/* --- Responsive Adjustments --- */
@media (max-width: 768px) {
    section {
        padding: 60px 5%;
    }
}


    /*
</style>
@stack('styles')
