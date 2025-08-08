<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sauvegarde Complétée</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-wrapper {
            width: 100%;
            padding: 40px 0;
            background-color: #f2f4f8;
        }
        .email-content {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .email-header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .email-body h2 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .email-body p {
            font-size: 16px;
            margin: 12px 0;
        }
        .email-body strong {
            color: #2c3e50;
        }
        .download-links ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        .download-links li {
            margin: 10px 0;
        }
        .download-links a {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .download-links a:hover {
            background-color: #2980b9;
        }
        .email-footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-footer a {
            color: #999;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <h1>🛡️ Supagirl Backup System</h1>
            </div>
            <div class="email-body">
                <h2>✅ Sauvegarde terminée avec succès</h2>
                <p><strong>📁 Base de données :</strong> {{ $filenameDb }}</p>
                <p><strong>🗄️ Stockage :</strong> {{ $filenameStorage }}</p>
                <p><strong>📦 Taille totale :</strong> {{ $totalSize }}</p>

                <div class="download-links">
                    <h3>🔗 Liens de téléchargement :</h3>
                    <ul>
                        <li><a href="{{ $linkDb }}">Télécharger la base de données</a></li>
                        <li><a href="{{ $linkStorage }}">Télécharger le stockage</a></li>
                    </ul>
                </div>

                <p><strong>🕒 Date :</strong> {{ $date }}</p>
                <p><strong>🔖 Source :</strong> Supagirl</p>
            </div>
            <div class="email-footer">
                Cet email a été généré automatiquement par le système de sauvegarde.<br>
                Pour toute question, contactez <a href="mailto:support@supagirl.com">support@supagirl.com</a>
            </div>
        </div>
    </div>
</body>
</html>
