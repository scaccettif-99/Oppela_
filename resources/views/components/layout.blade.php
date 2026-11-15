<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Oppela! Abbigliamento</title>
    <link rel="icon" href="{{ asset('media/logo1.png') }}" type="image/png">
</head>
<body>
    <button id="scrollTopBtn" class="btn btn-warning">
        <i class="bi bi-arrow-up-circle-fill" style="font-size: 1.8rem;"></i>
    </button>
    <a href="https://wa.me/+393381520444" 
    target="_blank" 
    rel="noopener"
    id="whatsappBtn"
    aria-label="Contattaci su WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
    <x-nav/>
    
    <div class="min-vh-100">
        {{ $slot }}
    </div>
    
    <x-footer/>
    
</body>
</html>