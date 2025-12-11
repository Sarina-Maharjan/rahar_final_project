<!-- Single Widget -->
                            <div class="single-widget category">
                                <h3 class="title">Categories</h3>
                                <ul class="categor-list">
                                    @php
                                        $menu = App\Models\Category::getAllParentWithChild();
                                    @endphp

                                    @if ($menu)
                                        @foreach ($menu as $cat_info)
                                            <li class="parent-category">
                                                <label>
                                                    <input type="checkbox" name="category[]"
                                                    value="{{ $cat_info->id }}">
                                                    <a href="{{ route('product-cat', [$cat_info->slug]) }}">
                                                        {{ $cat_info->title }}
                                                    </a>
                                                </label>

                                                @if ($cat_info->child_cat->count() > 0)
                                                    <button type="button" class="toggle-subcat">+</button>
                                                    <ul class="sub-categories" style="display: none;">
                                                        @foreach ($cat_info->child_cat as $sub_menu)
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="subcategory[]"
                                                                        value="{{ $sub_menu->id }}">
                                                                        <a href="{{ route('product-cat', [$sub_menu->slug]) }}">
                                                                    {{ $sub_menu->title }}
                                                                        </a>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <!--/ End Single Widget -->
                            <!-- Shop By Price -->
                            <div class="single-widget range">
                                <h3 class="title">Shop by Price</h3>
                                <div class="price-filter">
                                    <div class="price-filter-inner">
                                        {{-- <div id="slider-range" data-min="10" data-max="2000" data-currency="%"></div>
												<div class="price_slider_amount">
												<div class="label-input">
													<span>Range:</span>
													<input type="text" id="amount" name="price_range" value='@if (!empty($_GET['price'])) {{$_GET['price']}} @endif' placeholder="Add Your Price"/>
												</div>
											</div> --}}
                                        @php
                                            $max = DB::table('products')->max('price');
                                            // dd($max);
                                        @endphp
                                        <div id="slider-range" data-min="0" data-max="{{ $max }}"></div>
                                        <div class="product_filter">
                                            <button type="submit" class="filter_button">Filter</button>
                                            <div class="label-input">
                                                <span>Range:</span>
                                                <input style="" type="text" id="amount" readonly />
                                                <input type="hidden" name="price_range" id="price_range"
                                                    value="@if (!empty($_GET['price'])) {{ $_GET['price'] }} @endif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <ul class="check-box-list">
										<li>
											<label class="checkbox-inline" for="1"><input name="news" id="1" type="checkbox">$20 - $50<span class="count">(3)</span></label>
										</li>
										<li>
											<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">$50 - $100<span class="count">(5)</span></label>
										</li>
										<li>
											<label class="checkbox-inline" for="3"><input name="news" id="3" type="checkbox">$100 - $250<span class="count">(8)</span></label>
										</li>
									</ul> --}}
                            </div>
                            <!--/ End Shop By Price -->
                            <!-- Single Widget -->
                            <div class="single-widget recent-post">
                                <h3 class="title">Recent post</h3>
                                {{-- {{dd($recent_products)}} --}}
                                @foreach ($recent_products as $product)
                                    <!-- Single Post -->
                                    @php
                                        $photo = explode(',', $product->photo);
                                    @endphp
                                    <div class="single-post first">
                                        <div class="image">
                                            <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}">
                                        </div>
                                        <div class="content">
                                            <h5><a
                                                    href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                            </h5>
                                            @php
                                                $org = $product->price - ($product->price * $product->discount) / 100;
                                            @endphp
                                            @if (isset($cookie_rate) && isset($symbol))
                                                <p class="price"><del
                                                        class="text-muted">${{ number_format($product->price / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}</del>
                                                    ${{ number_format($org / $cookie_rate, $symbol == 'Rs' || $symbol == '₹' ? 2 : 3) }}
                                                </p>
                                            @else
                                                <p class="price"><del
                                                        class="text-muted">${{ number_format($product->price / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}</del>
                                                    ${{ number_format($org / $user_currency_rate_to_npr, $user_currency_symbol == 'Rs' || $user_currency_symbol == '₹' ? 2 : 3) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End Single Post -->
                                @endforeach
                            </div>
                            <!--/ End Single Widget -->
                            <!-- Single Widget -->
                            <!-- <div class="single-widget category">
                                                                        <h3 class="title">Brands</h3>
                                                                        <ul class="categor-list">
                                                                            @php
                                                                                $brands = DB::table('brands')
                                                                                    ->orderBy('title', 'ASC')
                                                                                    ->where('status', 'active')
                                                                                    ->get();
                                                                            @endphp
                                                                            @foreach ($brands as $brand)
    <li><a href="{{ route('product-brand', $brand->slug) }}">{{ $brand->title }}</a></li>
    @endforeach
                                                                        </ul>
                                                                    </div> -->
                            <!--/ End Single Widget -->