<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $hospital->title ?? config('app.name') }}</title>

    <!-- Mobile Specific Metas
        ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Health Care Medical Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="AmhLogix">
    <meta name="generator" content="AmhLogix HTML Template v1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/'.$hospital->logo) }}" type="image/x-icon">

    <!-- Essential stylesheets
        =====================================-->
    <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
    <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
    <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        #appointment-form {
            scroll-margin-top: 100px;
            /* Adjust based on your header height */
        }
    </style>
</head>

<body id="top">

    <header>
        <div class="header-top-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <ul class="top-bar-info list-inline-item pl-0 mb-0">
                            <li class="list-inline-item">
                                <a href="mailto:{{ $hospital->email ?? '' }}">
                                    <i class="icofont-support-faq mr-2"></i>
                                    {{ $hospital->email ?? 'NA' }}
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="icofont-location-pin mr-2"></i>
                                {{ $hospital->address ?? 'NA' }}
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-lg-right top-right-bar mt-2 mt-lg-0">
                            <a href="{{ $hospital->contact ?? 'NA' }}" class="text-white">
                                <span>Call Now : </span>
                                <span class="h4">{{ $hospital->contact ?? 'NA' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navigation" id="navbar">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('img/'.$hospital->logo) }}"
                        width="100"
                        alt="{{ $hospital->title }}"
                        class="rounded me-2">

                    <h2 class="title-color text-md">{{ $hospital->title }}</h2>

                </a>

                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain"
                    aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icofont-navigation-menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarmain">
                    <ul class="navbar-nav ml-auto">
                        <!-- <li class="nav-item active"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/service') }}">Services</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ url('/department') }}" id="dropdown02" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Department <i class="icofont-thin-down"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown02">
                                <li><a class="dropdown-item" href="{{ url('/department') }}">Departments</a></li>
                                <li><a class="dropdown-item" href="{{ url('/department-single') }}">Department Single</a></li>

                                <li class="dropdown dropdown-submenu dropright">
                                    <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0301" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdown0301">
                                        <li><a class="dropdown-item" href="#">Submenu 01</a></li>
                                        <li><a class="dropdown-item" href="#">Submenu 02</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ url('/doctor') }}" id="dropdown03" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Doctors <i class="icofont-thin-down"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown03">
                                <li><a class="dropdown-item" href="{{ url('/doctor') }}">Doctors</a></li>
                                <li><a class="dropdown-item" href="{{ url('/doctor-single') }}">Doctor Single</a></li>
                                <li><a class="dropdown-item" href="{{ url('/appointment') }}">Appoinment</a></li>

                                <li class="dropdown dropdown-submenu dropleft">
                                    <a class="dropdown-item dropdown-toggle" href="#!" id="dropdown0501" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sub Menu</a>

                                    <ul class="dropdown-menu" aria-labelledby="dropdown0501">
                                        <li><a class="dropdown-item" href="#">Submenu 01</a></li>
                                        <li><a class="dropdown-item" href="#">Submenu 02</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ url('/blog-sidebar') }}" id="dropdown05" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Blog <i class="icofont-thin-down"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown05">
                                <li><a class="dropdown-item" href="{{ url('/blog-sidebar') }}">Blog with Sidebar</a></li>
                                <li><a class="dropdown-item" href="{{ url('/blog-single') }}">Blog Single</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li> -->

                        @if (Route::has('login'))

                        @auth('front')
                        <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a></li>
                        @else
                        <li class="nav-item"><a href="{{ route('admin.login') }}" class="nav-link" target="_blank">Admin Portal</a>
                            <!-- <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Log in</a>

                            @if (Route::has('register'))
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a>
                            @endif -->
                            @endauth

                            <!-- @endif -->

                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- Slider Start -->
    <section class="banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-xl-7">
                    <div class="block">
                        <div class="divider mb-3"></div>
                        <span class="text-uppercase text-sm letter-spacing ">Total Health care solution</span>
                        <h1 class="mb-3 mt-3">Your most trusted health partner</h1>

                        <p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p>
                        <div class="btn-container ">
                            <a href="#appointment-form" class="btn btn-main-2 btn-icon btn-round-full">Make appoinment <i class="icofont-simple-right ml-2  "></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="feature-block d-lg-flex">
                        <div class="feature-item mb-5 mb-lg-0">
                            <div class="feature-icon mb-4">
                                <i class="icofont-surgeon-alt"></i>
                            </div>
                            <span>24 Hours Service</span>
                            <h4 class="mb-3">Online Appoinment</h4>
                            <p class="mb-4">Get ALl time support for emergency.We have introduced the principle of family medicine.</p>
                            <a href="#appointment-form" class="btn btn-main btn-round-full">Make a appoinment</a>
                        </div>

                        <div class="feature-item mb-5 mb-lg-0">
                            <div class="feature-icon mb-4">
                                <i class="icofont-ui-clock"></i>
                            </div>
                            <span>Timing schedule</span>
                            <h4 class="mb-3">Working Hours</h4>
                            <ul class="w-hours list-unstyled">
                                <li class="d-flex justify-content-between">Sun - Wed : <span>8:00 - 17:00</span></li>
                                <li class="d-flex justify-content-between">Thu - Fri : <span>9:00 - 17:00</span></li>
                                <li class="d-flex justify-content-between">Sat - sun : <span>10:00 - 17:00</span></li>
                            </ul>
                        </div>

                        <div class="feature-item mb-5 mb-lg-0">
                            <div class="feature-icon mb-4">
                                <i class="icofont-support"></i>
                            </div>
                            <span>Emegency Cases</span>
                            <h4 class="mb-3">{{ $hospital->contact ?? 'NA' }}</h4>
                            <p>Get ALl time support for emergency.We have introduced the principle of family medicine.Get Conneted with us for any urgency .</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="about-img">
                        <img src="images/about/img-1.jpg" alt="" class="img-fluid">
                        <img src="images/about/img-2.jpg" alt="" class="img-fluid mt-4">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="about-img mt-4 mt-lg-0">
                        <img src="images/about/img-3.jpg" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about-content pl-4 mt-4 mt-lg-0">
                        <h2 class="title-color">Personal care <br>& healthy living</h2>
                        <p class="mt-4 mb-5">We provide best leading medicle service Nulla perferendis veniam deleniti ipsum officia dolores repellat laudantium obcaecati neque.</p>

                        <a href="javascript:void(0);" id="servicesBtn" class="btn btn-main-2 btn-icon btn-round-full">Our
                            Services <i class="icofont-simple-right ml-3"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cta-section ">
        <div class="container">
            <div class="cta position-relative">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-stat">
                            <i class="icofont-doctor"></i>
                            <span class="h3 counter" data-count="58">0</span>k
                            <p>Happy People</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-stat">
                            <i class="icofont-flag"></i>
                            <span class="h3 counter" data-count="700">0</span>+
                            <p>Surgery Comepleted</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-stat">
                            <i class="icofont-badge"></i>
                            <span class="h3 counter" data-count="40">0</span>+
                            <p>Expert Doctors</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="counter-stat">
                            <i class="icofont-globe"></i>
                            <span class="h3 counter" data-count="20">0</span>
                            <p>Worldwide Branch</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section service gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <h2>Award winning patient care</h2>
                        <div class="divider mx-auto my-4"></div>
                        <p>Lets know moreel necessitatibus dolor asperiores illum possimus sint voluptates incidunt molestias nostrum laudantium. Maiores porro cumque quaerat.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-laboratory text-lg"></i>
                            <h4 class="mt-3 mb-3">Laboratory services</h4>
                        </div>

                        <div class="content">
                            <p class="mb-4">Saepe nulla praesentium eaque omnis perferendis a doloremque.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-heart-beat-alt text-lg"></i>
                            <h4 class="mt-3 mb-3">Heart Disease</h4>
                        </div>
                        <div class="content">
                            <p class="mb-4">Saepe nulla praesentium eaque omnis perferendis a doloremque.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-tooth text-lg"></i>
                            <h4 class="mt-3 mb-3">Dental Care</h4>
                        </div>
                        <div class="content">
                            <p class="mb-4">Saepe nulla praesentium eaque omnis perferendis a doloremque.</p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-crutch text-lg"></i>
                            <h4 class="mt-3 mb-3">Body Surgery</h4>
                        </div>

                        <div class="content">
                            <p class="mb-4">Saepe nulla praesentium eaque omnis perferendis a doloremque.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-brain-alt text-lg"></i>
                            <h4 class="mt-3 mb-3">Neurology Sargery</h4>
                        </div>
                        <div class="content">
                            <p class="mb-4">Saepe nulla praesentium eaque omnis perferendis a doloremque.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="service-item mb-4">
                        <div class="icon d-flex align-items-center">
                            <i class="icofont-dna-alt-1 text-lg"></i>
                            <h4 class="mt-3 mb-3">Gynecology</h4>
                        </div>
                        <div class="content">
                            <p class="mb-4">Saepe nulla praesentium eaque omnis perferendis a doloremque.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section appoinment">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 ">
                    <div class="appoinment-content">
                        <img src="images/about/img-3.jpg" alt="" class="img-fluid">
                        <div class="emergency">
                            <h2 class="text-lg"><i class="icofont-phone-circle text-lg"></i>{{ $hospital->contact ?? 'NA' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 ">
                    <div id="appointment-form" class="appoinment-wrap mt-5 mt-lg-0">
                        <h2 class="mb-2 title-color">Book appoinment</h2>
                        <p class="mb-4">Mollitia dicta commodi est recusandae iste, natus eum asperiores corrupti qui velit . Iste dolorum atque similique praesentium soluta.</p>
                        <form class="appoinment-form" method="POST" action="{{ route('appointments.store') }}">
                            @csrf

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="form-control" name="doctor_id" required>
                                            <option value="">Select Doctor</option>

                                            @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">
                                                {{ $doctor->name }}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input
                                            type="date"
                                            name="appointment_date"
                                            class="form-control"
                                            required
                                            value="{{ old('appointment_date') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            name="appointment_time"
                                            class="form-control"
                                            placeholder="10:30 AM"
                                            value="{{ old('appointment_time') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            name="patient_name"
                                            class="form-control"
                                            placeholder="Full Name"
                                            value="{{ old('patient_name') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            name="phone_number"
                                            class="form-control"
                                            placeholder="03XXXXXXXXX"
                                            value="{{ old('phone_number') }}"
                                            required>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group-2 mb-4">
                                <textarea
                                    class="form-control"
                                    rows="6"
                                    name="notes"
                                    placeholder="Write your message...">{{ old('notes') }}</textarea>

                                <input type="hidden" name="source" value="website">
                            </div>

                            <button type="submit" class="btn btn-main btn-round-full">
                                Make Appointment
                                <i class="icofont-simple-right ml-2"></i>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section testimonial-2 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title text-center">
                        <h2>We served over 5000+ Patients</h2>
                        <div class="divider mx-auto my-4"></div>
                        <p>Lets know moreel necessitatibus dolor asperiores illum possimus sint voluptates incidunt molestias nostrum laudantium. Maiores porro cumque quaerat.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 testimonial-wrap-2">
                    <div class="testimonial-block style-2  gray-bg">
                        <i class="icofont-quote-right"></i>

                        <div class="testimonial-thumb">
                            <img src="images/team/test-thumb1.jpg" alt="" class="img-fluid">
                        </div>

                        <div class="client-info ">
                            <h4>Amazing service!</h4>
                            <span>John Partho</span>
                            <p>
                                They provide great service facilty consectetur adipisicing elit. Itaque rem, praesentium, iure, ipsum magnam deleniti a vel eos adipisci suscipit fugit placeat.
                            </p>
                        </div>
                    </div>

                    <div class="testimonial-block style-2  gray-bg">
                        <div class="testimonial-thumb">
                            <img src="images/team/test-thumb2.jpg" alt="" class="img-fluid">
                        </div>

                        <div class="client-info">
                            <h4>Expert doctors!</h4>
                            <span>Mullar Sarth</span>
                            <p>
                                They provide great service facilty consectetur adipisicing elit. Itaque rem, praesentium, iure, ipsum magnam deleniti a vel eos adipisci suscipit fugit placeat.
                            </p>
                        </div>

                        <i class="icofont-quote-right"></i>
                    </div>

                    <div class="testimonial-block style-2  gray-bg">
                        <div class="testimonial-thumb">
                            <img src="images/team/test-thumb3.jpg" alt="" class="img-fluid">
                        </div>

                        <div class="client-info">
                            <h4>Good Support!</h4>
                            <span>Kolis Mullar</span>
                            <p>
                                They provide great service facilty consectetur adipisicing elit. Itaque rem, praesentium, iure, ipsum magnam deleniti a vel eos adipisci suscipit fugit placeat.
                            </p>
                        </div>

                        <i class="icofont-quote-right"></i>
                    </div>

                    <div class="testimonial-block style-2  gray-bg">
                        <div class="testimonial-thumb">
                            <img src="images/team/test-thumb4.jpg" alt="" class="img-fluid">
                        </div>

                        <div class="client-info">
                            <h4>Nice Environment!</h4>
                            <span>Partho Sarothi</span>
                            <p class="mt-4">
                                They provide great service facilty consectetur adipisicing elit. Itaque rem, praesentium, iure, ipsum magnam deleniti a vel eos adipisci suscipit fugit placeat.
                            </p>
                        </div>
                        <i class="icofont-quote-right"></i>
                    </div>

                    <div class="testimonial-block style-2  gray-bg">
                        <div class="testimonial-thumb">
                            <img src="images/team/test-thumb1.jpg" alt="" class="img-fluid">
                        </div>

                        <div class="client-info">
                            <h4>Modern Service!</h4>
                            <span>Kolis Mullar</span>
                            <p>
                                They provide great service facilty consectetur adipisicing elit. Itaque rem, praesentium, iure, ipsum magnam deleniti a vel eos adipisci suscipit fugit placeat.
                            </p>
                        </div>
                        <i class="icofont-quote-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section clients">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title text-center">
                        <h2>Partners who support us</h2>
                        <div class="divider mx-auto my-4"></div>
                        <p>Lets know moreel necessitatibus dolor asperiores illum possimus sint voluptates incidunt molestias nostrum laudantium. Maiores porro cumque quaerat.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row clients-logo">
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/1.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/2.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/3.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/4.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/5.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/6.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/3.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/4.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/5.png" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="client-thumb">
                        <img src="images/about/6.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer Start -->
    <footer class="footer section gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mr-auto col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <div class="logo">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('img/'.$hospital->logo) }}"
                                    width="100"
                                    alt="{{ $hospital->title }}"
                                    class="rounded-pill me-2">

                                <h3 class="title-color mt-3">{{ $hospital->title }}</h3>
                            </a>
                        </div>
                        <p>Tempora dolorem voluptatum nam vero assumenda voluptate, facilis ad eos obcaecati tenetur veritatis eveniet distinctio possimus.</p>

                        <ul class="list-inline footer-socials mt-4">
                            <li class="list-inline-item">
                                <a href="#"><i class="icofont-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="icofont-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="icofont-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <h4 class="text-capitalize mb-3">Department</h4>
                        <div class="divider mb-4"></div>

                        <ul class="list-unstyled footer-menu lh-35">
                            <li><a href="#!">Surgery </a></li>
                            <li><a href="#!">Wome's Health</a></li>
                            <li><a href="#!">Radiology</a></li>
                            <li><a href="#!">Cardioc</a></li>
                            <li><a href="#!">Medicine</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="widget mb-5 mb-lg-0">
                        <h4 class="text-capitalize mb-3">Support</h4>
                        <div class="divider mb-4"></div>

                        <ul class="list-unstyled footer-menu lh-35">
                            <li><a href="#!">Terms & Conditions</a></li>
                            <li><a href="#!">Privacy Policy</a></li>
                            <li><a href="#!">Company Support </a></li>
                            <li><a href="#!">FAQ's</a></li>
                            <li><a href="#!">Company Licence</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="widget widget-contact mb-5 mb-lg-0">
                        <h4 class="text-capitalize mb-3">Get in Touch</h4>
                        <div class="divider mb-4"></div>

                        <div class="footer-contact-block mb-4">
                            <div class="icon d-flex align-items-center">
                                <i class="icofont-email mr-3"></i>
                                <span class="h6 mb-0">Support Available for 24/7</span>
                            </div>
                            <h4 class="mt-2"><a href="mailto:{{ $hospital->email ?? 'NA' }}">{{ $hospital->email ?? 'NA' }}</a></h4>
                        </div>

                        <div class="footer-contact-block">
                            <div class="icon d-flex align-items-center">
                                <i class="icofont-support mr-3"></i>
                                <span class="h6 mb-0">Mon to Fri : 08:30 - 18:00</span>
                            </div>
                            <h4 class="mt-2"><a href="tel:{{ $hospital->contact ?? 'NA' }}">{{ $hospital->contact ?? 'NA' }}</a></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-btm py-4 mt-5">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <div class="copyright">
                            Copyright &copy; {{ now()->year }}, Designed &amp; Developed by <a href="#!">AmhLogix</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="subscribe-form text-lg-right mt-5 mt-lg-0">
                            <form action="#" class="subscribe">
                                <input type="text" class="form-control" placeholder="Your Email address" required>
                                <button type="submit" class="btn btn-main-2 btn-round-full">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <a class="backtop scroll-top-to" href="#top">
                            <i class="icofont-long-arrow-up"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="modal" id="specialitiesModal" tabindex="-1" role="dialog" aria-labelledby="specialitiesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h3>All Services</h3>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        @foreach($specialities as $speciality)

                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

                            <div class="card h-100">

                                <div class="card-body text-center">

                                    <h5>{{ $speciality->title }}</h5>

                                    <!-- <p>{{ $speciality->remarks }}</p> -->

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- 
    Essential Scripts
    =====================================-->
    <script src="plugins/jquery/jquery.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script>
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="plugins/shuffle/shuffle.min.js"></script>

    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA"></script>
    <script src="plugins/google-map/gmap.js"></script>

    <script src="js/script.js"></script>
    <script>
        $(document).ready(function() {

            $('#servicesBtn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $('#specialitiesModal').modal('show');
            });

        });
    </script>


</body>

</html>