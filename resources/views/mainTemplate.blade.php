<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container-fluid">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-md-offset-2">
                    <p class="footer-info">
                        This is task 3.2 from learning program.
                        &copy Oleksandr Nazarenko 2017</p>
                </div>
                <div class="col-md-5">
                    @yield('footer-content')
                </div>
            </div>
        </div>
    </footer>

    <script src="/js/app.js"></script>
    @yield('scripts')
</body>
</html>