<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Food Bank Main Page</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    <style>
    .client-img {
    width: 120px;
    height: 120px;
    overflow: hidden;
    border: 4px solid #fff;
    margin: 0px auto 20px;
    border-radius: 100%;
}
.carousel-content {
    padding: 50px 0px;
}
.carousel-content h3 span {
    font-size: 17px;
    font-weight: normal;
    color: #e8e8e8;
    text-transform: uppercase;
}
.client-img img {
    width: 100%;
}
#testimonial {
    text-align: center;
    padding: 40px 0px;
    color: #fff;
}
#testimonial .carousel-control-prev,
#testimonial .carousel-control-next {
    font-size: 36px;
}
#testimonial h2 {
    font-size: 40px;
    font-style: italic;
    border-bottom: 1px solid #7fbdff;
    padding-bottom: 20px;
    display: inline-block;
}
</style>

    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Food Bank</a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#testimony">Testimony</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">About</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{ route('users.register1') }}">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header style="background-image: url({{asset('img/food.jpg')}}); opacity: 0.7;" class="masthead bg-primary text-white text-center">
            <div  class="container d-flex align-items-center flex-column">
                <!-- Masthead Avatar Image-->
                <!-- Masthead Heading-->
                <div >
                <h1 class="masthead-heading text-uppercase mb-0" style="color: black;" >Food Bank</h1>
                </div>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line" style="background-color:black ;"></div>
                    <div class="divider-custom-icon" ><i style="color:black ;" class="fas fa-star"></i></div>
                    <div class="divider-custom-line" style="background-color:black ;"></div>
                </div>
                <!-- Masthead Subheading-->
                <p class="masthead-subheading font-weight-light mb-0" style="color: black;">Food sharing platform</p>
            </div>
        </header>
        <!-- Portfolio Section-->
        <section class="page-section portfolio" id="about">
            <div class="container">
                <!-- Portfolio Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">About</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4 ml-auto"><p class="lead">This platform tends to encourage food crowdsourcing by enabling the crowd to participate in solving the scarcity of food in some societies</p></div>
                    <div class="col-lg-4 mr-auto"><p class="lead">It is easy to use, You just need to create your account to start using it!</p></div>
                    
                    
                 </div> {{--End of row carousel --}}
            </div>
        </section>
        <!-- Testimoney Section-->
        <section class="page-section bg-primary text-white mb-0" id="testimony">
            <div class="container">
                <!-- Testimoney Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">Testimonial Slider</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Testimoney Section Content-->
                @if (count($posts)!= 0) 
                <div class="row justify-content-center">
                    <section id="testimonial" class="bg-primary">
                                <div class="col-12">
                                    <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
                                        
                                        <!-- Slide Indicators -->
                                        <ol class="carousel-indicators">
                                            <li data-target="#testimonialCarousel" data-slide-to="0" class="active"></li>
                                        </ol>
                                        <div style="height: 100%;" class="carousel-inner" role="listbox">
                                            <!-- Slide 1 -->
                                            @foreach( $posts as $key => $post)
                                            <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                                                <div class="carousel-content">
                                                    <h3>{{$post->title}} <br></h3>
                                                <p class="col-md-8 offset-md-2">{{$post->content}}</p>
                                                <p><span>Author: {{$post->user->name}}</span></p>
                                                </div>
                                            </div>
                                            @endforeach
                                            <!-- Slider pre and next arrow -->
                                            <a class="carousel-control-prev text-white" href="#testimonialCarousel" role="button" data-slide="prev">
                                            <i class="fas fa-chevron-left"></i>
                                            </a>
                                            <a class="carousel-control-next text-white" href="#testimonialCarousel" role="button" data-slide="next">
                                            <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </div>
                                           

                                    </div>
                                </div>
                    </section>
                    @else
                    <div class="row">
                        <p>No Testimoney found</p>
                    </div>
                </div>
                @endif
                <!-- About Section Button-->
                
            </div>
        </section>
        
        <!-- Footer-->
        <footer class="footer text-center">
            <div class="container">
                <div class="row">
                    <!-- Footer Location-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <h4 class="text-uppercase mb-4">Location</h4>
                        <p class="lead mb-0">
                            94300 Kota Samarahan
                            <br />
                            Sarawak, Malayisa
                        </p>
                    </div>
                    <!-- Footer Social Icons-->
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        {{-- <h4 class="text-uppercase mb-4">Around the Web</h4>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a> --}}
                    </div>
                    <!-- Footer About Text-->
                    <div class="col-lg-4">
                        <h4 class="text-uppercase mb-4">About Food Bank</h4>
                        <p class="lead mb-0">
                            It is a Final Year Project done in Univeristy Malaysia Sarawak.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright © FCSIT FYP Project 2020</small></div>
        </div>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>
        
       
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src="assets/mail/jqBootstrapValidation.js"></script>
        <script src="assets/mail/contact_me.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

