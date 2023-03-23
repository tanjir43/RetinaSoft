@extends('layouts.app')

@section('content')
    <!-- Hero-->
    <section class="pb-4 pt-5" style="background-color:#cdebcb ">
    <div class="container py-5">
        <div class="row align-items-center mt-2 mt-md-0 pt-md-4 pt-lg-5 pb-5">
        <div class="col-md-5 order-md-2 mb-5 mb-md-0">
            <div class="parallax mx-auto" style="max-width: 526px;">
            <div class="parallax-layer position-relative" data-depth="0.1"><img src="{{asset('images/illustration.png')}}" alt="illustration"></div>
            </div>
        </div>
        <div class="col-md-7 order-md-1">
            <h2 class="text-dark pb-2 mb-4 mb-lg-5" style="max-width: 31.5rem;">We can Grow your Business with the Latest Technology</h2>
            <h2 class="h5 text-dark mb-4">Popular services</h2>
            <div class="d-flex flex-wrap"><a class="btn btn-translucent-dark btn-xs rounded-pill fs-sm me-2 mb-2" href="#"><i class="fi-search me-2"></i> Web Development Services</a><a class="btn btn-translucent-dark btn-xs rounded-pill fs-sm me-2 mb-2" href="#"><i class="fi-search me-2"></i>Digital Marketing</a><a class="btn btn-translucent-dark btn-xs rounded-pill fs-sm me-2 mb-2" href="#"><i class="fi-search me-2"></i>IT Solutions</a></div>
        </div>
        </div>
    </div>
    </section>
    <!-- Categories-->
    <section class="position-relative bg-white rounded-xxl-4 zindex-5" style="margin-top: -30px;">
    <div class="container pt-5" style="background-color:#cdebcb ">
        <h2 class="h3 pb-2 pb-sm-3">Our Services</h2>
        <div class="d-flex flex-wrap flex-column flex-sm-row"><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4 mb-2 mb-sm-3 me-sm-3 me-xxl-4" href="job-board-catalog.html">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-accounting"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">Accounting</h3></a><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4 mb-2 mb-sm-3 me-sm-3 me-xxl-4" href="job-board-catalog.html">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-pie-chart"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">Marketing &amp; PR</h3></a><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4 mb-2 mb-sm-3 me-sm-3 me-xxl-4" href="job-board-catalog.html">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-meds"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">Medicine</h3></a><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4 mb-2 mb-sm-3 me-sm-3 me-xxl-4" href="job-board-catalog.html">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-plant"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">Agriculture</h3></a><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4 mb-2 mb-sm-3 me-sm-3 me-xxl-4" href="job-board-catalog.html">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-computer"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">IT</h3></a><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4 mb-2 mb-sm-3 me-sm-3 me-xxl-4" href="job-board-catalog.html">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-security"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">Security</h3></a>
        <div class="dropdown mb-2 mb-sm-3"><a class="icon-box card flex-row align-items-center flex-shrink-0 card-hover border-0 bg-secondary rounded-pill py-2 ps-2 pe-4" href="job-board-catalog.html" data-bs-toggle="dropdown">
            <div class="icon-box-media bg-light text-primary rounded-circle me-2"><i class="fi-dots-horisontal"></i></div>
            <h3 class="icon-box-title fs-sm ps-1 pe-2 mb-0">More</h3></a>
        </div>
        </div>
    </div>
    </section>

    <!-- Top companies-->
    <section class="container" style="background-color:#cdebcb ">
    <h6 class="h6 text-center text-sm-start mb-sm-4 pt-4">Affiliations & Partnership with <span class="text-primary">20+ Local & International Companies.</span></h6>
    <div class="tns-carousel-wrapper tns-nav-outside tns-nav-outside-flush">
        <div class="tns-carousel-inner" data-carousel-options="{&quot;controls&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:2},&quot;480&quot;:{&quot;items&quot;:3},&quot;680&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 12},&quot;850&quot;:{&quot;items&quot;:5, &quot;gutter&quot;: 16},&quot;1100&quot;:{&quot;items&quot;:6, &quot;gutter&quot;: 24}}}">
        <div class="pb-1"><a class="swap-image" href="job-board-employer-single.html"><img class="swap-to" src="{{asset('images/agri_pro.png')}}" width="196" alt="Microsoft"><img class="swap-from" src="{{asset('images/agri_pro.png')}}" width="130px" alt="Agripro"></a></div>
        <div class="pb-1"><a class="swap-image" href="job-board-employer-single.html"><img class="swap-to" src="{{asset('images/janla.png')}}" width="196" alt="Indeed"><img class="swap-from" src="{{asset('images/janla.png')}}" width="130px" alt="Janla Associates"></a></div>
        <div class="pb-1"><a class="swap-image" href="job-board-employer-single.html"><img class="swap-to" src="{{asset('images/shoe.png')}}" width="196" alt="Coca Cola"><img class="swap-from" src="{{asset('images/shoe.png')}}" width="130px" alt="Shoe Master"></a></div>
        <div class="pb-1"><a class="swap-image" href="job-board-employer-single.html"><img class="swap-to" src="{{asset('images/agri_pro.png')}}" width="196" alt="Slack"><img class="swap-from" src="{{asset('images/agri_pro.png')}}" width="130px" alt="Slack"></a></div>
        <div class="pb-1"><a class="swap-image" href="job-board-employer-single.html"><img class="swap-to" src="{{asset('images/janla.png')}}" width="196" alt="Walmart"><img class="swap-from" src="{{asset('images/janla.png')}}" width="130px" alt="Walmart"></a></div>
        <div class="pb-1"><a class="swap-image" href="job-board-employer-single.html"><img class="swap-to" src="{{asset('images/agri_pro.png')}}" width="196" alt="Google"><img class="swap-from" src="{{asset('images/agri_pro.png')}}" width="130px" alt="Google"></a></div>
        </div>
    </div>
    </section>
@endsection