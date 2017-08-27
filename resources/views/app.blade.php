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
        <div id="app" class="grid">
            <today area="today"></today>

            <weather area="weather"></weather>

            <spotify area="spotify"></spotify>

            <news area="news"></news>

            <stash area="stash"></stash>
        </div>

        <script src="{{ mix('assets/js/app.js') }}"></script>
    </body>
</html>
