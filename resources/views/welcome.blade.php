<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Azzam's Website</title>

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Akshar:wght@500&family=Fascinate&family=Oleo+Script+Swash+Caps&family=Oswald:wght@500&family=Padauk:wght@700&family=Poppins:ital,wght@0,200;0,600;0,900;1,500;1,700&family=Square+Peg&family=Updock&family=Water+Brush&display=swap');
            #brand {padding: 0; font-family: 'Fascinate'; color: #253852; width: min(300px, 60vw); height: 50px; display: flex; flex-direction: row; justify-content: center;}
            #photo {height: 50px; width: 50px; border-radius: 25px; background-color: green; margin: 0 10px;}
            #brand-text {margin: 0; width: 200px; display: flex; align-items: center;}
            .nav-link {font-family: 'Akshar'; color: #777777; font-size: 20px; font-weight: normal;}
            .dropdown-item, .btn {font-family: 'Akshar'; color: #777777; font-size: 17px; font-weight: normal;}
            .form-control, .me-2 {font-family: 'Akshar'; font-size: 17px; font-weight: normal; color: red;}
            .active {color: #c397f8;}
    </style>
        </style>
    </head>
    <body class="antialiased">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><div id= 'brand'><div id= 'photo'></div><div id= 'brand-text'>Azzam's Website</div></div></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="enter text here" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>
