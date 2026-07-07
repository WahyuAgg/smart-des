<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

    <div class="container-fluid">

        <a class="navbar-brand" href="/">

            Sistem Desa

        </a>

        <div class="ms-auto">

            <span class="navbar-text text-white">

                {{ auth()->user()->name ?? 'Guest' }}

            </span>

        </div>

    </div>

</nav>