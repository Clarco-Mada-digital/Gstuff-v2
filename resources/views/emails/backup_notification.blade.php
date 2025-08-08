<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sauvegarde Complétée</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px;">
        <h2 style="color: #2c3e50;">✅ Sauvegarde terminée avec succès</h2>

        <p><strong>📁 Base de données :</strong> {{ $filenameDb }}</p>
        <p><strong>🗄️ Stockage :</strong> {{ $filenameStorage }}</p>
        <p><strong>📦 Taille totale :</strong> {{ $totalSize }}</p>

        <h3>🔗 Liens de téléchargement :</h3>
        <ul>
            <li><a href="{{ $linkDb }}" style="color: #3498db;">Télécharger la base de données</a></li>
            <li><a href="{{ $linkStorage }}" style="color: #3498db;">Télécharger le stockage</a></li>
        </ul>

        <p style="margin-top: 20px; font-size: 0.9em; color: #7f8c8d;">🕒 Date : {{ $date }}</p>
    </div>
</body>
</html>
