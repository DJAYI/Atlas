<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Asistencia</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            max-width: 21cm;
            margin: 0 auto;
        }

        header {
            width: 100%;
            height: 15vh;
            overflow: hidden;
        }

        .full-width {
            width: 100%;
            height: auto;
            object-fit: cover;
            object-position: top;
            display: block;
        }

        .center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .text-container {
            width: 80%;
            text-align: justify;
            margin: 0 auto;
        }

        .mb-4 {
            margin-bottom: 0.5rem;
        }

        .align-right {
            text-align: right;
            margin-right: 10%;
            font-size: 0.8rem;
        }

        footer {
            display: flex;
            justify-content: center;
            margin-top: auto;
            width: 100%;
        }

        .footer-image {
            width: 100%;
            max-height: 100vh;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img src="{{ public_path('images/certificates/header.png') }}" alt="Header Image" class="full-width">
        </header>

        <main>
            <div class="center-content">
                <h1 class="bold" style="font-size: 1rem;">LA SUSCRITA SECRETARIA GENERAL DE LA FUNDACIÓN UNIVERSITARIA
                </h1>
                <h1 class="bold" style="font-size: 1rem;">COMFENALCO CARTAGENA</h1>
                <h1 class="bold" style="font-size: 1rem;">CERTIFICA QUE:</h1>
            </div>

            <div class="mt-4 center-content">
                <p style="font-size: 1.25rem;">
                    <span class="bold">{{ $fullname }}</span>
                </p>
            </div>

            <div class="mt-4 center-content">
                <div class="text-container">
                    <p style="font-weight: bold; color: #444;">Nombre del Evento: <span
                            style="font-weight: normal;">{{ $event->name }}</span></p>
                    <p class="mb-4" style="font-size: 0.8rem;">
                        Participó en el evento <strong>{{ $event->name }}</strong> del programa
                        <strong>{{ $person->career->name }}</strong> en modalidad
                        <strong>{{ $event->modality }}</strong> durante
                        <strong>{{ \Carbon\Carbon::parse($event->start_date)->diffInDays(\Carbon\Carbon::parse($event->end_date)) + 1 }}</strong>
                        días.
                    </p>
                </div>
            </div>

            <div class="mt-4 center-content">
                <h1 class="bold" style="font-size: 1rem;">MARÍA FERNANDA NOVA DEL GIÚDICE</h1>
                <h1 class="bold" style="font-size: 1rem;">SECRETARIA GENERAL</h1>
            </div>

            <div class="mt-4 align-right">
                <p>Proyectado por:</p>
                <p>CSalgado</p>
                <p>Jefe de Internacionalización y Alianzas</p>
            </div>
        </main>

        <footer>
            <img src="{{ public_path('images/certificates/footer.png') }}" alt="Footer Image" class="footer-image">
        </footer>
    </div>
</body>

</html>
