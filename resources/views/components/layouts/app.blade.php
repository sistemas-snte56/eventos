<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<title>{{ $title ?? 'Page Title' }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	<meta name="description" content="This is meta description">
	<meta name="author" content="Themefisher">
	<link rel="shortcut icon" href="{{asset('front/images/favicon.png')}}" type="image/x-icon">
	<link rel="icon" href="{{asset('front/images/favicon.png')}}" type="image/x-icon">

	<!-- # Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

	<!-- # CSS Plugins -->
	<link rel="stylesheet" href="{{asset('front/plugins/slick/slick.css')}}">
	<link rel="stylesheet" href="{{asset('front/plugins/font-awesome/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('front/plugins/font-awesome/brands.css')}}">
	<link rel="stylesheet" href="{{asset('front/plugins/font-awesome/solid.css')}}">

	<!-- # Main Style Sheet -->
	<link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery (Select2 lo necesita) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  
    
    

    

</head>

<body>

    <!-- navigation -->
    <header class="navigation bg-tertiary">
        <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}" wire:navigate>
                    <img loading="prelaod" decoding="async" class="img-fluid" width="260" src="{{asset('front/images/logo-snte@4x.png')}}" alt="Wallet">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <li class="nav-item"> <a class="nav-link" href="{{route('home')}}" wire:navigate>Inicio</a></li>
                        <li class="nav-item "> <a class="nav-link" href="https://snte.org.mx/seccion56/" target="_blank" >Página principal</a></li>
                        <li class="nav-item "> <a class="nav-link" href="https://cdnsnte1.s3.us-west-1.amazonaws.com/wp-content/uploads/sites/53/2022/09/09222121/Directorio-de-la-Directiva-Seccional-de-la-Seccion-56-del-SNTE-2022.pdf" target="_blank" >Directiva Seccional Sindical</a></li>
                        <li class="nav-item "><a class="nav-link " href="{{route('search-participante')}}" wire:navigate>Buscar</a></li>
                    </ul>
                    @auth
                        <a href="{{ route('home') }}" wire:navigate class="btn btn-outline-primary">Dashboard</a>
                    @endauth

                    @guest
                        <a href="{{ route('filament.admin.auth.login') }}" wire:navigate class="btn btn-outline-primary">Login</a>
                    @endguest                			
                </div>
            </div>
        </nav>
    </header>
    <!-- /navigation -->


    {{ $slot }}


    <footer class="section-sm bg-tertiary">
        <div class="container">
            
            <div class="row align-items-center mt-5 text-center text-md-start">
                <div class="col-lg-4">
                    <a href="{{route('home')}}" wire:navigate>
                    <img loading="prelaod" decoding="async" class="img-fluid" width="260" src="{{asset('front/images/logo-unidad@3x.png')}}" alt="Wallet">
                    </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                            <ul class="list-unstyled list-inline mb-0 text-lg-center">
                                <li class="list-inline-item me-4">
                                    <a class="text-black" href="https://snte.org.mx/web/avisodeprivacidad/" target="_blank">Aviso de Privacidad</a>
                                </li>
                                <li class="list-inline-item me-4">
                                    <a class="text-black" href="https://optisnte.mx/" target="_blank">Terminos &amp; Condiciones</a>
                                </li>
                            </ul>
                </div>
                <div class="col-lg-4 col-md-6 text-md-end mt-4 mt-md-0">
                    <ul class="list-unstyled list-inline mb-0 social-icons">
                        <li class="list-inline-item me-3"><a title="Explorer Facebook Profile" class="text-black" href="https://www.facebook.com/snte56informafanpage/"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item me-3"><a title="Explorer Twitter Profile" class="text-black" href="https://x.com/snte56veracruz?lang=es"><i class="fab fa-twitter"></i></a>
                        </li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <!-- # JS Plugins -->
    <script src="{{asset('front/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('front/plugins/slick/slick.min.js')}}"></script>
    <script src="{{asset('front/plugins/bootstrap/bootstrap.min.js')}}"></script>

  

    <!-- Main Script -->
    <script src="{{asset('front/js/script.js')}}"></script>
    @livewireScripts
</body>
</html>