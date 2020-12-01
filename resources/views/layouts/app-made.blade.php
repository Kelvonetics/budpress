<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>EASY | Schoo<</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('assets/made/images/e.jpg') }}">

        <!--Google Font link-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


        <link rel="stylesheet" href="{{ asset('assets/made/css/slick/slick.css') }}"> 
        <link rel="stylesheet" href="{{ asset('assets/made/css/slick/slick-theme.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/made/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/made/css/iconfont.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/made/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/made/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/made/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/made/css/bootsnav.css') }}">

        <!-- xsslider slider css -->


        <!--<link rel="stylesheet" href="assets/css/xsslider.css">-->




        <!--For Plugins external css-->
        <!--<link rel="stylesheet" href="assets/css/plugins.css" />-->

        <!--Theme custom css -->
        <link rel="stylesheet" href="{{ asset('assets/made/css/style.css') }}">
        <!--<link rel="stylesheet" href="assets/css/colors/maron.css">-->

        <!--Theme Responsive css-->
        <link rel="stylesheet" href="{{ asset('assets/made/css/responsive.css') }}" />

        <script src="{{ asset('assets/made/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    </head>

    <body data-spy="scroll" data-target=".navbar-collapse">


        <!-- Preloader -->
        <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                    <div class="object" id="object_four"></div>
                </div>
            </div>
        </div><!--End off Preloader -->


        <div class="culmn">
            <!--Home page style-->


            <nav class="navbar navbar-default bootsnav navbar-fixed">
                <div class="navbar-top bg-grey fix">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="navbar-callus text-left sm-text-center">
                                    <ul class="list-inline">
                                        <li><a href=""><i class="fa fa-phone"></i> Call us: +2348085038711</a></li>
                                        <li><a href=""><i class="fa fa-envelope-o"></i> Contact us: info@easyschool.com.ng</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="navbar-socail text-right sm-text-center">
                                    <ul class="list-inline">
                                        <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                        <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href=""><i class="fa fa-instagram"></i></a></li>
                                        <li><a href=""><i class="fa fa-youtube"></i></a></li>
                                        <li><a href=""><i class="fa fa-whatsapp"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Start Top Search -->
                <div class="top-search">
                    <div class="container">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                        </div>
                    </div>
                </div>
                <!-- End Top Search -->


                <div class="container"> 
                    <div class="attr-nav">
                        <ul>
                            <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        </ul>
                    </div> 

                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="fa fa-bars"></i>
                        </button>
                        <a class="navbar-brand" href="#brand">
                            <img src="{{ asset('assets/made/images/e.jpg') }}" style="width: 100px; height: 40px" class="logo" alt="">
                            {{-- <img src="{{ asset('assets/made/images/logo.png') }}" class="logo logo-scrolled" alt=""> --}}
                        </a>

                    </div>
                    <!-- End Header Navigation -->

                    <!-- navbar menu -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ url('/') }}" target="_blank">Admin</a></li>   
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#home">Home</a></li>                    
                            <li><a href="#features">About</a></li>
                            <li><a href="#business">Admission</a></li>
                            <li><a href="#work">Yearbook</a></li>
                            <li><a href="#test">Forum</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div> 

            </nav>







                @yield('content')







            <footer id="contact" class="footer action-lage bg-black p-top-80">
                <!--<div class="action-lage"></div>-->
                <div class="container">
                    <div class="row">
                        <div class="widget_area">
                            <div class="col-md-3">
                                <div class="widget_item widget_about">
                                    <h5 class="text-white">About Us</h5>
                                    <p class="m-top-20">EASY School is a citadel of qualitative and achievers academic center located in a serene environment. With well quipped modern school facilities for excellence.</p>
                                    <div class="widget_ab_item m-top-30">
                                        <div class="item_icon"><i class="fa fa-location-arrow"></i></div>
                                        <div class="widget_ab_item_text">
                                            <h6 class="text-white">Location</h6>
                                            <p>
                                                123, Not=rth Way, Steel Island Lagos</p>
                                        </div>
                                    </div>
                                    <div class="widget_ab_item m-top-30">
                                        <div class="item_icon"><i class="fa fa-phone"></i></div>
                                        <div class="widget_ab_item_text">
                                            <h6 class="text-white">Phone :</h6>
                                            <p>+2348085038711</p>
                                        </div>
                                    </div>
                                    <div class="widget_ab_item m-top-30">
                                        <div class="item_icon"><i class="fa fa-envelope-o"></i></div>
                                        <div class="widget_ab_item_text">
                                            <h6 class="text-white">Email Address :</h6>
                                            <p>info@easyschool.com.ng</p>
                                        </div>
                                    </div>
                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->

                            <div class="col-md-3"> 
                                <div class="widget_item widget_latest sm-m-top-50">
                                    <h5 class="text-white">Latest News</h5>
                                    <div class="widget_latst_item m-top-30">
                                        <div class="item_icon"><img src="{{ asset('assets/made/images/sport2.jpg') }}" alt="" /></div>
                                        <div class="widget_latst_item_text">
                                            <p>School Annual Inter-house Sport For This Year</p>
                                            <a href=""> {{date('d')}} <sup>th</sup>  {{date('M, Y')}} </a>
                                        </div>
                                    </div>
                                    <div class="widget_latst_item m-top-30">
                                        <div class="item_icon"><img src="{{ asset('assets/made/images/proof.jpg') }}" alt="" /></div>
                                        <div class="widget_latst_item_text">
                                            <p>Annaul EASY School Excursion Programme</p>
                                            <a href=""> {{date('d')}} <sup>th</sup>  {{date('M, Y')}} </a>
                                        </div>
                                    </div>
                                    <div class="widget_latst_item m-top-30">
                                        <div class="item_icon"><img src="{{ asset('assets/made/images/classPic.jpg') }}" alt="" /></div>
                                        <div class="widget_latst_item_text">
                                            <p>Final Year School Debates For This Term</p>
                                            <a href=""> {{date('d')}} <sup>th</sup>  {{date('M, Y')}} </a>
                                        </div>
                                    </div>
                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->

                            <div class="col-md-3">
                                <div class="widget_item widget_service sm-m-top-50">
                                    <h5 class="text-white">Latest News</h5>
                                    <ul class="m-top-20">
                                        <li class="m-top-20"><a href=""><i class="fa fa-angle-right"></i> Debates</a></li>
                                        <li class="m-top-20"><a href=""><i class="fa fa-angle-right"></i> Inter-house Sport</a></li>
                                        <li class="m-top-20"><a href=""><i class="fa fa-angle-right"></i> Visitation Day</a></li>
                                        <li class="m-top-20"><a href=""><i class="fa fa-angle-right"></i> Mock-Exams</a></li>
                                        <li class="m-top-20"><a href=""><i class="fa fa-angle-right"></i> Themes</a></li>
                                        <li class="m-top-20"><a href=""><i class="fa fa-angle-right"></i> Support Forums</a></li>
                                    </ul>
                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->

                            <div class="col-md-3">
                                <div class="widget_item widget_newsletter sm-m-top-50">
                                    <h5 class="text-white">Newsletter</h5>
                                    <form class="form-inline m-top-30">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter you Email">
                                            <button type="submit" class="btn text-center"><i class="fa fa-arrow-right"></i></button>
                                        </div>

                                    </form>
                                    <div class="widget_brand m-top-40">
                                        <a href="" class="text-uppercase"> <img src="{{ asset('assets/made/images/e.jpg') }}" style="width: 100px; height: 40px" class="logo" alt=""> </a>
                                        <p>For latest news about Admission, Exams and Result, Sign up for newsletter today <br> Follow us on </p>
                                    </div>
                                    <ul class="list-inline m-top-20">
                                        <li>-  <a href=""><i class="fa fa-facebook"></i></a></li>
                                        <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                        <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href=""><i class="fa fa-instagram"></i></a></li>
                                        <li><a href=""><i class="fa fa-youtube"></i></a></li>
                                        <li><a href=""><i class="fa fa-whatsapp"></i></a></li>
                                    </ul>

                                </div><!-- End off widget item -->
                            </div><!-- End off col-md-3 -->
                        </div>
                    </div>
                </div>

                <div class="main_footer fix bg-mega text-center p-top-40 p-bottom-30 m-top-80">
                    <div class="col-md-12">
                        <p class="wow fadeInRight" data-wow-duration="1s">
                            Designed By    <i class="fa fa-power"></i>  by  <a target="_blank" href="#">I-Clone Concept</a>      {{date('Y')}}. All Rights Reserved
                        </p>
                    </div>
                </div>
            </footer>




        </div>

        <!-- JS includes -->

        <script src="{{ asset('assets/made/js/vendor/jquery-1.11.2.min.js') }}"></script>
        <script src="{{ asset('assets/made/js/vendor/bootstrap.min.js') }}"></script>

        <script src="{{ asset('assets/made/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/made/js/jquery.magnific-popup.js') }}"></script>
        <script src="{{ asset('assets/made/js/jquery.easing.1.3.js') }}"></script>
        <script src="{{ asset('assets/made/css/slick/slick.js') }}"></script>
        <script src="{{ asset('assets/made/css/slick/slick.min.js') }}"></script>
        <script src="{{ asset('assets/made/js/jquery.collapse.js') }}"></script>
        <script src="{{ asset('assets/made/js/bootsnav.js') }}"></script>



        <script src="{{ asset('assets/made/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/made/js/main.js') }}"></script>




        @yield('script')

    </body>
</html>
