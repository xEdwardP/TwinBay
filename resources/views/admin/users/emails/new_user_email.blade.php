<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Bienvenido a {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(27, 58, 47, 0.2);
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .header {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="%23ffffff" fill-opacity="0.1" d="M0,64L48,101.3C96,139,192,213,288,229.3C384,245,480,203,576,181.3C672,160,768,160,864,165.3C960,171,1056,181,1152,197.3C1248,213,1344,235,1392,245.3L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header .subtitle {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .car-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
            position: relative;
            z-index: 1;
        }

        .content {
            padding: 40px 30px;
            background: white;
        }

        .welcome-message {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            border-left: 5px solid #007bff;
            position: relative;
        }

        .password-section {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #00a8ff;
            text-align: center;
            border: 2px dashed #f39c12;
            position: relative;
        }

        .password-section::before {
            content: "🔒";
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 10px;
            border-radius: 50%;
            font-size: 24px;
        }

        .password-value {
            font-size: 32px;
            font-weight: 900;
            color: #e74c3c;
            letter-spacing: 3px;
            margin: 15px 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .steps {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
        }

        .steps h3 {
            color: #5a67d8;
            margin-bottom: 20px;
            font-size: 18px;
            text-align: center;
        }

        .step {
            display: flex;
            align-items: center;
            margin: 15px 0;
            padding: 15px;
            background: white;
            border-radius: 10px;
            border-left: 4px solid #5a67d8;
            transition: transform 0.2s;
        }

        .step:hover {
            transform: translateX(5px);
        }

        .step-number {
            background: #5a67d8;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .footer p {
            margin: 10px 0;
            opacity: 0.8;
        }

        .security-note {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            color: #0c5460;
        }

        .security-note strong {
            color: #0c5460;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 15px;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }

            .password-value {
                font-size: 24px;
                letter-spacing: 2px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="car-icon"></div>
            <h1>{{ config('app.name') }}</h1>
            <div class="subtitle">
                Gestión inteligente y segura de espacios de estacionamiento
            </div>
        </div>

        <div class="content">
            <div class="welcome-message">
                👋 ¡Bienvenido, {{ $user->name }}!
            </div>

            <div class="info-card">
                <p style="margin-bottom: 15px; color: #2c3e50; font-size: 16px">
                    ✔ Tu cuenta ha sido creada exitosamente.<br />
                    Ahora puedes gestionar tus espacios de estacionamiento de manera
                    eficiente y segura con nosotros.
                </p>
            </div>

            <div class="password-section">
                <h3 style="color: #e67e22; margin-top: 20px">
                    Tu Contraseña Temporal
                </h3>
                <div class="password-value">{{ $tempPassword }}</div>
                <p style="color: #d68910; font-weight: 500; margin-top: 10px">
                    Guarda esta contraseña en un lugar seguro
                </p>
            </div>

            <div class="steps">
                <h1>Pasos para acceder al sistema:</h1>

                <div class="step">
                    <div class="step-number">1</div>
                    <div>
                        <strong>Inicia Sesión:</strong>
                        <span style="color: #666">Usa tu email y la contraseña temporal.</span>
                    </div>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div>
                        <strong>Cambia tu contraseña:</strong>
                        <span style="color: #666">Crea una contraseña personal y segura.</span>
                    </div>
                </div>
            </div>

            <div style="text-align: center">
                <a href="{{ url('/login') }}" class="button">🔒 Iniciar Sesión</a>
            </div>

            <div class="security-note">
                <strong>📄 Datos de acceso:</strong><br />
                <strong>Email:</strong>&nbsp;{{ $user->email }}<br />
                <strong>Contraseña Temporal:</strong>&nbsp;{{ $tempPassword }}<br /><br />
                <strong>Importante:</strong>&nbsp;Por razones de seguridad, te
                recomendamos cambiar tu contraseña temporal en tu primer inicio de
                sesión.
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Gestión inteligente y segura de espacios de estacionamiento</p>
            <p>&copy; 2025 TwinBay. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>
