@extends('frontend.layouts.master')

@section('title', 'Thangka Store')

@section('main-content')
    @php
        $cookie_rate = Cookie::get('currency_rate');
        $symbol = Cookie::get('currency_symbol');
        $country_name = Cookie::get('country_name');

    @endphp

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Shop List</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
                        <!-- Trigger Button -->
                    <input type="button" value="Open Filters" class="open-filter-btn btn btn-primary d-lg-none mt-3" data-bs-toggle="modal" data-bs-target="#filterModal">
    <form action="{{ route('shop.filter') }}" method="POST">
        @csrf
        <!-- Product Style 1 -->
        <section class="product-area shop-sidebar shop-list shop section" style="padding: 0">
            <div class="container">
                <div class="row">

                    

                    <!-- SIDEBAR (Desktop Only) -->
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="shop-sidebar">
                            @include('frontend.partials.filter-sidebar')
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-bottom-sheet">
                            <div class="modal-content rounded-top-4 shadow-lg">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">X</button>
                                </div>

                                <div class="modal-body">
                                    @include('frontend.partials.filter-sidebar')

                                    <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="9" @if (!empty($_GET['show']) && $_GET['show'] == '9') selected @endif>09
                                                </option>
                                                <option value="15" @if (!empty($_GET['show']) && $_GET['show'] == '15') selected @endif>15
                                                </option>
                                                <option value="21" @if (!empty($_GET['show']) && $_GET['show'] == '21') selected @endif>21
                                                </option>
                                                <option value="30" @if (!empty($_GET['show']) && $_GET['show'] == '30') selected @endif>30
                                                </option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'title') selected @endif>
                                                    Name</option>
                                                <option value="price" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price') selected @endif>
                                                    Price</option>
                                                <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>
                                                    Category</option>
                                                <!-- <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>Brand</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li><a href="{{ route('product-grids') }}"><i class="fa fa-th-large"></i></a></li>
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                </div>

                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Apply Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top d-none d-lg-block">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="9" @if (!empty($_GET['show']) && $_GET['show'] == '9') selected @endif>09
                                                </option>
                                                <option value="15" @if (!empty($_GET['show']) && $_GET['show'] == '15') selected @endif>15
                                                </option>
                                                <option value="21" @if (!empty($_GET['show']) && $_GET['show'] == '21') selected @endif>21
                                                </option>
                                                <option value="30" @if (!empty($_GET['show']) && $_GET['show'] == '30') selected @endif>30
                                                </option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'title') selected @endif>
                                                    Name</option>
                                                <option value="price" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'price') selected @endif>
                                                    Price</option>
                                                <option value="category" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'category') selected @endif>
                                                    Category</option>
                                                <!-- <option value="brand" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'brand') selected @endif>Brand</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li><a href="{{ route('product-grids') }}"><i class="fa fa-th-large"></i></a></li>
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            @if (count($products))
                                @foreach ($products as $product)
                                    {{-- {{$product}} --}}
                                    <!-- Start Single List -->
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-6">
                                                <div class="single-product">
                                                    <div class="product-img">
                                                        <a href="{{ route('product-detail', $product->slug) }}">
                                                            @php
                                                                $photo = explode(',', $product->photo);
                                                            @endphp
                                                            <img class="default-img" src="{{ $photo[0] }}"
                                                                alt="{{ $photo[0] }}">
                                                            <img class="hover-img" src="{{ $photo[0] }}"
                                                                alt="{{ $photo[0] }}">
                                                        </a>
                                                        <div class="button-head">
                                                            <div class="product-action">
                                                                <a data-toggle="modal" data-target="#{{ $product->id }}"
                                                                    title="Quick View" href="#"><i
                                                                        class=" ti-eye"></i><span>Quick Shop</span></a>
                                                                <a title="Wishlist"
                                                                    href="{{ route('add-to-wishlist', $product->slug) }}"
                                                                    class="wishlist" data-id="{{ $product->id }}"><i
                                                                        class=" ti-heart "></i><span>Add to
                                                                        Wishlist</span></a>
                                                            </div>
                                                            <div class="product-action-2">
                                                                <a title="Add to cart"
                                                                    href="{{ route('add-to-cart', $product->slug) }}">Add
                                                                    to cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6 col-12">
                                                <div class="list-content">
                                                    <div class="product-content">
                                                        <h3 class="title"><a
                                                                href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                                        </h3>
                                                        <div class="product-price">
                                                            @php
                                                                $after_discount =
                                                                    $product->price -
                                                                    ($product->price * $product->discount) / 100;
                                                            @endphp
                                                            @if (isset($cookie_rate) && isset($symbol))
                                                                <del>${{ number_format($product->price / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}</del>
                                                                <span>${{ number_format($after_discount / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}</span>
                                                            @else
                                                                <del>${{ number_format($product->price / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}</del>
                                                                <span>${{ number_format($after_discount / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}</span>
                                                            @endif
                                                        </div>

                                                        {{-- <p>{!! html_entity_decode($product->summary) !!}</p> --}}
                                                    </div>
                                                    <p class="des pt-2">{!! html_entity_decode($product->summary) !!}</p>
                                                    <a href="javascript:void(0)" class="btn cart"
                                                        data-id="{{ $product->id }}">Buy Now!</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single List -->
                                @endforeach
                            @else
                                <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                            @endif
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{$products->appends($_GET)->links()}} 
                            </div>
                        </div> --}}
                                                @include('frontend.layouts.pagination', ['pagination' => $products])
                    </div>
                </div>
            </div>
        </section>
        <!--/ End Product Style 1  -->
    </form>
    <!-- Modal -->
    @if ($products)
        @foreach ($products as $key => $product)
            <div class="modal fade" id="{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @php
                                                $photo = explode(',', $product->photo);
                                                // dd($photo);
                                            @endphp
                                            @foreach ($photo as $data)
                                                <div class="single-slider">
                                                    <img src="{{ $data }}" alt="{{ $data }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{ $product->title }}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    {{-- <i class="yellow fa fa-star"></i>
															<i class="yellow fa fa-star"></i>
															<i class="yellow fa fa-star"></i>
															<i class="yellow fa fa-star"></i>
															<i class="fa fa-star"></i> --}}
                                                    @php
                                                        $rate = DB::table('product_reviews')
                                                            ->where('product_id', $product->id)
                                                            ->avg('rate');
                                                        $rate_count = DB::table('product_reviews')
                                                            ->where('product_id', $product->id)
                                                            ->count();
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($rate >= $i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{ $rate_count }} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if ($product->stock > 0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{ $product->stock }} in
                                                        stock</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i>
                                                        {{ $product->stock }} out stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount =
                                                $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        @if (isset($cookie_rate) && isset($symbol))
                                            <h3><small><del
                                                        class="text-muted">${{ number_format($product->price / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}</del></small>
                                                ${{ number_format($after_discount / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}
                                            </h3>
                                        @else
                                            <h3><small><del
                                                        class="text-muted">${{ number_format($product->price / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}</del></small>
                                                ${{ number_format($after_discount / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}
                                            </h3>
                                        @endif
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if ($product->size)
                                            <div class="size">
                                                <h4>Size</h4>
                                                <ul>
                                                    @php
                                                        $sizes = explode(',', $product->size);
                                                        // dd($sizes);
                                                    @endphp
                                                    @foreach ($sizes as $size)
                                                        <li><a href="#" class="one">{{ $size }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="{{ route('single-add-to-cart') }}" method="POST">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                    <input type="text" name="quant[1]" class="input-number"
                                                        data-min="1" data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                                <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                                    class="btn min"><i class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                            <!-- ShareThis BEGIN -->
                                            <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection
@push('styles')
    <style>
         .pagination {
            display: flex;
        }

        
        .pagination .page-link {
            transition: all 0.3s ease;
            border: none;
            color: #8d002f;
        }

        .pagination .page-link:hover {
            background-color: #f0f0f0;
            text-decoration: none;
        }

        .pagination .active .page-link {
            background-color: #8d002f !important;
            color: #fff !important;
            box-shadow: 0 0 8px rgba(151, 40, 44, 0.5);
        }

        .filter_button {
            /* height:20px; */
            text-align: center;
            background: #F7941D;
            padding: 8px 16px;
            margin-top: 10px;
            color: white;
        }

        .open-filter-btn{
            color: #fff !important;
            background: #000 !important;
        }
        /* Makes modal appear from bottom like a bottom sheet */
        .modal-bottom-sheet .modal-dialog {
            position: fixed;
            bottom: 0;
            margin: 0;
            width: 100%;
            max-width: 100%;
            transition: transform 0.3s ease-in-out;
        }

        .modal.fade .modal-dialog {
            transform: translateY(100%);
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
        }

        @media only screen and (max-width: 450px) {
    .modal-dialog .modal-content .modal-header {

        position: static;
        padding: 14px 22px;
    }

    button.btn-close {
    position: absolute;
    right: 15px;
    top: 14px;
    width: 25px;
    height: 22px;
    color: #fff;
    background: #000;
}
}
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function() {
          

            // Toggle subcategories
            $('.toggle-subcat').click(function(e) {
                e.preventDefault(); // In case it's a button or link
                $(this).siblings('.sub-categories').slideToggle();
            });
        });
    </script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							// document.location.href=document.location.href;
						}); 
                    }
                }
            })
        });
	</script> --}}
    <script>
        $(document).ready(function() {
            /*----------------------------------------------------*/
            /*  Jquery Ui slider js
            /*----------------------------------------------------*/
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;
                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function(event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }
            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.toggle-subcat');

            toggles.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const subcat = this.nextElementSibling;
                    const isVisible = subcat.style.display === 'block';

                    subcat.style.display = isVisible ? 'none' : 'block';
                    this.textContent = isVisible ? '+' : '–';
                });
            });
        });
    </script>

    <script>
    let lastOpenedProductImg = null;

    // Store the last clicked .product-img when modal is opened
    $('[data-toggle="modal"]').on('click', function () {
        lastOpenedProductImg = $(this).closest('.product-img');
    });

    // On modal close, reset the layout of only that product
    $(document).on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open').css('padding-right', '');
        $('.modal-backdrop').remove();

        if (lastOpenedProductImg) {
            // Force layout reset
            lastOpenedProductImg.css('position', 'static'); // change to something else briefly
            void lastOpenedProductImg[0].offsetHeight;       // force reflow
            lastOpenedProductImg.css('position', 'relative'); // back to original

            // Optional: remove any forced styles (cleanup)
            setTimeout(() => {
                lastOpenedProductImg.removeAttr('style');
            }, 100);
        }

        lastOpenedProductImg = null; // reset
    });
</script>
@endpush
