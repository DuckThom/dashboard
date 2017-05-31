<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme" content="#22717F">

        <title>{{ config('app.name') }}</title>

        <link href="{{ mix('assets/css/normalize.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ mix('assets/css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <div class="column-wrapper small horizontal" id="today">
                <div class="column column-6">
                    <div class="column-wrapper small horizontal">
                        <div class="column column-6">
                            <div class="column-wrapper small vertical">
                                <div class="column column-3">
                                    <today></today>
                                </div>
                            </div>
                        </div>
                        <div class="column column-6">
                            <weather></weather>
                        </div>
                    </div>
                </div>
                <div class="column column-6">
                    <div class="column-wrapper small horizontal">
                        <news></news>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ mix('assets/js/app.js') }}"></script>
    </body>
</html>
