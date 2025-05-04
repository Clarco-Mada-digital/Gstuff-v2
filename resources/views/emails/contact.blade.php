<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau message de contact</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            color: #111827;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .email-header {
            background-color: #05595B;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .email-content {
            padding: 30px;
        }

        .email-content h2 {
            margin-top: 0;
            font-size: 24px;
            color: #111827;
        }

        .detail {
            margin: 20px 0;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .detail p {
            margin: 10px 0;
        }

        .label {
            font-weight: bold;
            color: #374151;
        }

        .footer {
            background-color: #f3f4f6;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            padding: 15px;
        }

        a {
            color: #05595B;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>📬 Nouveau message via le formulaire de contact</h1>
        </div>

        <div class="email-content">
            <h2>🧾 Détails du message</h2>

            <div class="detail">
                <p><span class="label">👤 Nom :</span> {{ $messageData['name'] }}</p>
                <p><span class="label">📧 Email :</span> <a href="mailto:{{ $messageData['email'] }}">{{ $messageData['email'] }}</a></p>
                <p><span class="label">📝 Sujet :</span> {{ $messageData['subject'] }}</p>
            </div>

            <h3 style="margin-bottom: 5px;">💬 Message :</h3>
            <p style="white-space: pre-wrap; line-height: 1.6;">{{ $messageData['message'] }}</p>
        </div>

        <div class="footer">
            Ce message a été envoyé via le site <a href="{{ config('app.url') }}">{{ config('app.name') }}</a><br>
            Ne répondez pas à ce message directement si vous utilisez une adresse "noreply".
        </div>
    </div>
</body>
</html>

