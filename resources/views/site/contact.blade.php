@extends('site.layout')
@section('title', 'Contato')
@section('content')
<section class="home-page home-img" style="background:
    url('assets/img/banner/page.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-content">
                    <div class="page-text">
                        <h4>Wellcome to Our Resturent</h4>
                        <h2>Contact Us</h2>
                    </div>
                    <div class="page-add">
                        <ul>
                            <li><a class="page-active" href="https://preetheme.com/liton/foodbar/index.html">Home</a></li>
                            <li><a href="https://preetheme.com/liton/foodbar/product-details.html">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-us -->
<section class="contact-us-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="contact-box">
                    <div class="cnt-icon">
                        <i class="fas fa-comment-alt"></i>
                    </div>
                    <div class="cnt-text">
                        <h3>Email Address</h3>
                        <p>info@gmail.com</p>
                        <p>foodbar@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-box">
                    <div class="cnt-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="cnt-text">
                        <h3>Phone Number</h3>
                        <p>+389438398</p>
                        <p>+489839838</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-box">
                    <div class="cnt-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="cnt-text">
                        <h3>Email Address</h3>
                        <p>18/A, Mirpur Born Town Dhaka, <br>Bangladesh</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-40">
            <div class="col-lg-6 order-lg-1 order-2">
                <div class="contact-form">
                    <form id="contact-form" method="POST" action="mail.php">
                        <div class="form-group col-12">
                            <label>Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="name" required="" placeholder="Name">
                        </div>
                        <div class="form-group col-12">
                            <label>Email<span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" name="email" required="" placeholder="Email">
                        </div>
                        <div class="form-group col-12">
                            <label>Message<span class="text-danger">*</span>
                            </label>
                            <textarea name="message" class="form-control" cols="10" rows="6"></textarea>
                        </div>
                        <div class="button-bar">
                            <button type="submit" class="btn btn-lg">Place Order</button>
                        </div>
                    </form>
                    <div class="ajax-response"></div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="contuct-us-img">
                    <img src="contact_arquivos/cnt.jpg" alt="j">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- newsletters -->
<section class="Newsletter-area" style="background:url('assets/img/blog/news.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="subcribe-content">
                    <h3>Subscribe to our weakly Newsletter</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur, adipisicing
                        elit.</p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 align-self-center">
                <div class="subscribe">
                    <input type="search" placeholder="Enter Email">
                    <input type="submit" value="subscribe">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('plugins')
<script src="{{ asset('assets/site/js/ajax-form.js') }}"></script>
@endsection
