<header class="header shop">
 
                            @php
                                $settings = DB::table('settings')->get();

                            @endphp
                            

    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row" style="justify-content: space-between">
                    <div class="col-lg-1 col-1">
                        <!-- Logo -->
                    <div class="logo">
                        {{-- @php
                            $settings = DB::table('settings')->get();
                        @endphp --}}
                        <a href="{{ route('home') }}"><img style="height:50px;"
                                src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    </div>
                    <div class="col-lg-8 col-8">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{ Request::path() == 'home' ? 'active' : '' }}"><a
                                                    href="{{ route('home') }}">Home</a></li>
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}"><a
                                                    href="{{ route('about-us') }}">About Us</a></li>
                                            <li class="@if (Request::path() == 'product-grids' || Request::path() == 'product-lists') active @endif"><a
                                                    href="{{ route('product-grids') }}">Products</a><span
                                                    class="new">New</span></li>
                                            <!-- {{ Helper::getHeaderCategory() }} -->
                                            <!-- <li class="{{ Request::path() == 'blog' ? 'active' : '' }}"><a href="{{ route('blog') }}">Blog</a></li>									 -->

                                            <li class="{{ Request::path() == 'gallery' ? 'active' : ''}}"><a href="{{ route('gallery') }}">Gallery</a></li>
                                                                                        <li class="{{ Request::path() == 'customization' ? 'active' : ''}}"><a href="{{ route('customization') }}">Customization</a></li>
                                            <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a
                                                    href="{{ route('contact') }}">Contact Us</a></li>
                                                
                                        </ul>
                                        <!-- Nice Select field -->

                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>


                               <div class="col-lg-1 col-md-1 col-1 d-flex" style="justify-content:center;align-items:center;">
                    <!-- Top Right -->
                    <div class="right-content d-flex">
                        <div class="right-bar d-flex">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php
                                $total_prod = 0;
                                $total_amount = 0;
                            @endphp
                            @if (session('wishlist'))
                                @foreach (session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod += $wishlist_items['quantity'];
                                        $total_amount += $wishlist_items['amount'];
                                    @endphp
                                @endforeach
                            @endif
                            <a href="{{ route('wishlist') }}" class="single-icon"><i class="fa fa-heart-o"></i> <span
                                    class="total-count">{{ Helper::wishlistCount() }}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromWishlist()) }} Items</span>
                                        <a href="{{ route('wishlist') }}">View Wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @foreach (Helper::getAllProductFromWishlist() as $data)
                                            @php
                                                $photo = explode(',', $data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{ route('wishlist-delete', $data->id) }}" class="remove"
                                                    title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                        alt="{{ $photo[0] }}"></a>
                                                <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                        target="_blank">{{ $data->product['title'] }}</a></h4>
                                                <p class="quantity">{{ $data->quantity }} x - <span
                                                        class="amount">${{ number_format($data->price, 2) }}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            @if (isset($cookie_rate) && isset($symbol))
                                                <span
                                                    class="total-amount">{{ $symbol }}{{ number_format(Helper::totalWishlistPrice() / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}</span>
                                            @else
                                                <span
                                                    class="total-amount">{{ $user_currency_symbol }}{{ number_format(Helper::totalWishlistPrice() / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}</span>
                                            @endif

                                        </div>
                                        <a href="{{ route('cart') }}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        
                        <div class="sinlge-bar shopping">
                            <a href="{{ route('cart') }}" class="single-icon"><i class="ti-bag"></i> <span
                                    class="total-count">{{ Helper::cartCount() }}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ count(Helper::getAllProductFromCart()) }} Items</span>
                                        <a href="{{ route('cart') }}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @foreach (Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo = explode(',', $data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{ route('cart-delete', $data->id) }}" class="remove"
                                                    title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                        alt="{{ $photo[0] }}"></a>
                                                <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                        target="_blank">{{ $data->product['title'] }}</a></h4>
                                                <p class="quantity">{{ $data->quantity }} x - <span
                                                        class="amount">${{ number_format($data->price, 2) }}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            @if (isset($cookie_rate) && isset($symbol))
                                                <span
                                                    class="total-amount">{{ $symbol }}{{ number_format(Helper::totalCartPrice() / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}</span>
                                            @else
                                                <span
                                                    class="total-amount">{{ $user_currency_symbol }}{{ number_format(Helper::totalCartPrice() / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('checkout') }}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        </div>

                        <ul class="list-main">
                            
                            @auth
                                <!-- @if (Auth::user()->role == 'admin')
    <li><i class="ti-user"></i> <a href="{{ route('admin') }}"  target="_blank">Dashboard</a></li>
@else
    <li><i class="ti-user"></i> <a href="{{ route('user') }}"  target="_blank">Dashboard</a></li>
    @endif -->
                                <li><i class="ti-power-off" style="color:#fff;"></i> <a href="{{ route('user.logout') }}">Logout</a></li>
                            @else
                                <li><i class="ti-power-off" style="color:#fff;"></i><a href="{{ route('login.form') }}" style="color:#fff;">Login /</a> <a
                                        href="{{ route('register.form') }}" style="color:#fff;">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#categoryNiceSelect').on('change', function() {
                const selectedOption = $(this).find('option:selected');
        const value = selectedOption.val();
        const [selectedCurrency, selectedCountry] = value.split('||');

        console.log(selectedCountry);

        if (selectedCurrency && selectedCountry) {
            const newUrl = `/country/${selectedCurrency.toLowerCase()}/${selectedCountry}`;
            window.location.href = newUrl;
        }
            });
        });

        $(document).ready(function () {
    $('#countryNiceSelect').on('change', function () {
        const selectedOption = $(this).find('option:selected');
        const value = selectedOption.val();
        const [selectedCurrency, selectedCountry] = value.split('||');

        console.log(selectedCountry);

        if (selectedCurrency && selectedCountry) {
            const newUrl = `/country/${selectedCurrency.toLowerCase()}/${selectedCountry}`;
            window.location.href = newUrl;
        }
    });
});
    </script>
@endpush
