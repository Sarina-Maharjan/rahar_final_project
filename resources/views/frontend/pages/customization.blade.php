@extends('frontend.layouts.master')

@section('title','Thangka Store')

@section('main-content')

<style>
.custom-request-section {
    padding: 70px 5%;
    margin-top: 50px;
}

.custom-request-section h2 {
    text-align: center;
    margin-bottom: 35px;
    font-size: 2em;
    color: #8d002f;
}

.request-form {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-group label {
    font-weight: 600;
    font-size: 0.95rem;
}

.request-form input,
.request-form textarea {
    padding: 14px;
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    font-size: 1rem;
}

.request-form input:focus,
.request-form textarea:focus {
    border-color:#8d002f;
    outline: none;
}

.submit-btn {
    background:#8d002f;
    color: #fff;
    font-weight: 700;
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s;
}

.submit-btn:hover {
    background: #8d002f;
    transform: translateY(-2px);
}

    </style>

    <!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{ url('/') }}">Home<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="#">Customization</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<section class="custom-request-section" id="custom-request">
    <div class="container">

        <form class="request-form" action="#" method="POST">
            @csrf

            <div class="form-group">
                <label>Full Name*</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email Address*</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>What would you like?</label>
                <textarea name="details" rows="4" placeholder="Example: Crochet keyring with initials A.S, purple color…"></textarea>
            </div>

            <div class="form-group">
                <label>Deadline (If any)</label>
                <input type="date" name="deadline">
            </div>

            <button type="submit" class="submit-btn">Submit Request</button>
        </form>
    </div>
</section>


@include('frontend.layouts.newsletter')



@endsection
