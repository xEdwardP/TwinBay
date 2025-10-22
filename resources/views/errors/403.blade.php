<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 403 - Acceso Denegado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .error-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            transition: transform 0.3s ease;
        }

        .error-container:hover {
            transform: translateY(-5px)
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            color: #dc3545;
            line-height: 1;
            margin-bottom: 5px;
        }

        .error-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-top: 20px;
            color: #555;
        }

        .error-message {
            font-size: 1rem;
            color: #777;
            margin: 30px;
            line-height: 1.5;
        }

        .btn-home {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-home:hover {
            background-color: #0056b3;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 123, 125, 0.3);
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <h1 class="error-title">Acceso Denegado</h1>
        <p class="error-message">
            Lo sentimos, pero no tiene los permisos necesarios para acceder a esta página.<br>
            Contacta al administrador del sistema si crees que esto es un error.
        </p>
        <a href="{{ url('/home') }}" class="btn-home">Volver al Inicio</a>
    </div>
</body>

</html>
