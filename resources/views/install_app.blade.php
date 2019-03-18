<html>
    <head>
        <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/install_app.css') }}">
    </head>
    <body>
    <div class="container-fluid">
        <div class="install_app_wrap">
            <h2>Welcome</h2>
            <p>Please enter your Shopify URL </p>
            <div>
                <form action="{{ route('App.installHandle') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <input name="shop_domain" type="text" placeholder="Example: aliorder.myshopify.com" class="form-control">
                    </div>
                    <div>
                        <input class="button-style btn btn-primary" type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>