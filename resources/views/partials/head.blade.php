<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Layanan Surat') - SIAK Desa</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Inter', 'ui-sans-serif', 'system-ui'],
        },
        colors: {
          page: '#EEF2F6',
          navy: {
            900: '#0B172A',
            800: '#12233F',
            700: '#183156',
          },
          accent: {
            DEFAULT: '#0D9488',
            hover: '#0F766E',
            light: '#CCFBF1',
          },
        },
      },
    },
  }
</script>


<style>
  [x-cloak] { display: none !important; }
  body { background-color: #EEF2F6; }
</style>

@vite(['resources/css/app.css', 'resources/js/app.js'])

