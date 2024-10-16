<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIS MEDIA Store API Documentation</title>
    
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <!-- Swagger UI CSS -->
    <link rel="stylesheet" type="text/css" href="{{ l5_swagger_asset('default', 'swagger-ui.css') }}">

    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *, *:before, *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div id="swagger-ui" class="container mx-auto px-4 py-8"></div>

    <!-- Swagger UI JS -->
    <script src="{{ l5_swagger_asset('default', 'swagger-ui-bundle.js') }}"></script>
    <script src="{{ l5_swagger_asset('default', 'swagger-ui-standalone-preset.js') }}"></script>
    
    <script>
        window.onload = function() {
            // Initialize Swagger UI
            const ui = SwaggerUIBundle({
                dom_id: '#swagger-ui',
                url: "{!! $urlToDocs !!}",  // URL ke JSON file Swagger
                operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
                configUrl: {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
                validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
                // Oauth2 Redirect URL dihapus karena tidak digunakan
                requestInterceptor: function(request) {
                    request.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                    return request;
                },
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout"
            });

            window.ui = ui;
        };
    </script>
</body>
</html>
