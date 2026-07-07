<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Sistem Desa')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }

        main {
            background: #ffffff;
        }

        .step-circle {

            width: 40px;
            height: 40px;

            border: 2px solid #0d6efd;

            border-radius: 50%;

            display: flex;

            justify-content: center;

            align-items: center;

            margin: auto;

            font-weight: bold;

        }

        .step-box {
            width :1 px;
            height : 1 px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin:auto;

        }

        .step-line {

            flex: 1;

            height: 2px;

            background: #0d6efd;

            margin: 10 10px;

            /* mb-3; */

        }

        .step-circle.active {

            background: #0d6efd;

            color: white;

        }

.template-card {

    cursor: pointer;

    transition: .2s;

}

.template-card:hover {

    transform: translateY(-2px);

}

.template-card.selected {

    border: 2px solid #0d6efd;

    background-color: #e7f1ff;

}




    </style>

    @stack('styles')

</head>
