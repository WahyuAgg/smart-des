<!DOCTYPE html>
<html lang="id">

@include('partials.head')

<body>

    @include('partials.navbar')

    <div class="container-fluid">

        <div class="row">

            @include('partials.sidebar')

            <main class="col-md-10 px-4 py-4">

                @yield('content')

            </main>

        </div>

    </div>

    @include('partials.footer')

    @stack('scripts')


</body>

</html>