<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
        }

        .header {
            background: #00a650;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .tickets {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .ticket-num {
            display: inline-block;
            background: #1a1a1a;
            color: white;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 3px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ strtoupper(\App\Models\Setting::get('site_title', 'Sorteos')) }}</h1>
        </div>
        <div class="content">
            <h2>¡Hola {{ $venta->nombre_cliente }}!</h2>
            <p>Gracias por participar en nuestro sorteo: <strong>{{ $venta->sorteo->titulo }}</strong>.</p>
            <p>Tu compra ha sido procesado con éxito por un total de ${{ number_format($venta->total, 0, ',', '.') }}.
            </p>

            <div class="tickets">
                <h3>Tus números asignados son:</h3>
                <div>
                    @foreach($tickets as $ticket)
                        <span class="ticket-num">{{ $ticket->numero }}</span>
                    @endforeach
                </div>
            </div>

            <p>¡Mucha suerte!</p>
        </div>
        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_title', 'Sorteos') }}</p>
        </div>
    </div>
</body>

</html>