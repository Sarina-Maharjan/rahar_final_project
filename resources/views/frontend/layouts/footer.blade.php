
	<!-- Start Footer Area -->
	<footer class="footer">
		<div class="upToScroll buttonShow"><div class="whatsapp"><a  href="https://wa.me/113309513808" target="_blank"><h5><i class="fab fa-whatsapp"></i></h5></a></div><a href="javascript:void(0);" class="scrollToTop d-none"><i class="fa-solid fa-chevron-up"></i></a></div>
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
						<a href="/">
    <img src="{{ asset('/storage/photos/1/logo2.png') }}" alt="logo" width="250" style="margin-bottom: 30px;">
</a>

							@php
								$settings=DB::table('settings')->get();
							@endphp
							<p class="text">@foreach($settings as $data) {!! $data->short_des !!} @endforeach</p>
							<p class="call">Got Question? Call us 24/7<span><a href="tel:123456789">@foreach($settings as $data) {{$data->phone}} @endforeach</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Information</h4>
							<ul>
								<li><a href="{{route('about-us')}}">About Us</a></li>
								<li><a href="#">Faq</a></li>
								<li><a href="#">Terms & Conditions</a></li>
								<li><a href="{{route('contact')}}">Contact Us</a></li>
								<li><a href="#">Help</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Customer Service</h4>
							<ul>
								<li><a href="#">Payment Methods</a></li>
								<li><a href="#">Money-back</a></li>
								<li><a href="#">Returns</a></li>
								<li><a href="#">Shipping</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Get In Touch</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>@foreach($settings as $data) {{$data->address}} @endforeach</li>
									<li>@foreach($settings as $data) {{$data->email}} @endforeach</li>
									<li>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<div class="custom-social-buttons" style="
    display: flex;
    gap: 2px; /* very small gap */
    align-items: center;
	margin-top: 15px;
">
  <a href="https://www.facebook.com/sarina.sanu.mhj" target="_blank" rel="noopener" aria-label="Facebook" style="
      width: 40px;
      height: 40px;
      background-color: #000;
      border-radius: 50%;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 22px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      margin: 0 1px; /* minimal margin */
  " onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#000'">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="https://www.instagram.com/rahar_maya/" target="_blank" rel="noopener" aria-label="Instagram" style="
      width: 40px;
      height: 40px;
      background-color: #000;
      border-radius: 50%;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 22px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      margin: 0 1px;
  " onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#000'">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="https://www.tiktok.com/@thangka_store" target="_blank" rel="noopener" aria-label="TikTok" style="
      width: 40px;
      height: 40px;
      background-color: #000;
      border-radius: 50%;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 22px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      margin: 0 1px;
  " onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#000'">
    <i class="fab fa-tiktok"></i>
  </a>
  <a href="https://wa.me/13309513808" target="_blank" rel="noopener" aria-label="WhatsApp" style="
      width: 40px;
      height: 40px;
      background-color: #000;
      border-radius: 50%;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 22px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      margin: 0 1px;
  " onmouseover="this.style.backgroundColor='#555'" onmouseout="this.style.backgroundColor='#000'">
    <i class="fab fa-whatsapp"></i>
  </a>
</div>

						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © {{date('Y')}} Rahar Store -  All Rights Reserved. Site by : <a href="https://www.cyburning.com/">Sarina Maharjan</a></p>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="right">
								<img src="{{asset('backend/img/payments.png')}}" alt="#">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
    <script src="{{asset('frontend/js/jquery.min.js')}}" defer></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}" defer></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}" defer></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}" defer></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}" defer></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/js/colors.js')}}"></script> 
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}" defer></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}" defer></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}" defer></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}" defer></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}" defer></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}" defer></script>
	
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}" defer></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}" defer></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}" defer></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}" defer></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}" defer></script>

	<!-- Active JS -->
	<script src="{{asset('frontend/js/active.js')}}" defer></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>