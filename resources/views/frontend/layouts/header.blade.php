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
                    <div class="right-content">
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
