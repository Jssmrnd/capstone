@aware(['page'])

<html>
    <head>
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
    <body>
        @livewire('application-form')
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>