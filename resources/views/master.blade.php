<!DOCTYPE html>
<html lang="en" class="notranslate">

<head>
    @include('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Assets File --}}
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mix/app.css') }}">
    <link rel="stylesheet" href="{{asset('dist/select2/css/select2.min.css')}}">

    <script src="{{ asset('assets/mix/app.js') }}"></script>
    <script src="{{asset('dist/select2/js/select2.min.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <style>
        .custom-radio[type="radio"] { transform: scale(1.5); }
        .custom-control-label { cursor: pointer; }
    </style>

    <div id="app">
        <div class="main-wrapper">
            @auth
                @if (Auth::user()?->role === 'admin')
                    @include('layout.sb_admin')
                @elseif (Auth::user()?->role === 'user')
                    @include('layout.sb_user')
                @endif
            @endauth

            @yield('content')

            @auth
                @if (Auth::user()?->role === 'admin' || Auth::user()?->role === 'user')
                    @include('layout.footer')
                @endif
            @endauth
        </div>
    </div>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <script>
    $(document).ready(function() {
        if ($('.summernote').length > 0) {
            $('.summernote').summernote({
                placeholder: 'Tulis konten di sini...',
                tabsize: 2,
                height: 220,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear', 'fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']],
                ]
            });
        }
    });
    </script>
</body>
</html>