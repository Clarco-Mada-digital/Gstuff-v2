<?php
// Vérification des paramètres de configuration
$settings = [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
    'max_input_time' => ini_get('max_input_time'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'loaded_ini_file' => php_ini_loaded_file(),
    'php_version' => phpversion(),
    'sapi' => php_sapi_name()
];

// Fonction pour comparer les valeurs
function compareValues($current, $expected) {
    $current = strtoupper(trim($current, 'M'));
    $expected = strtoupper(trim($expected, 'M'));
    return $current == $expected ? '✅ OK' : '❌ Non';
}

// Paramètres attendus
$expected = [
    'upload_max_filesize' => '128M',
    'post_max_size' => '132M',
    'memory_limit' => '256M',
    'max_execution_time' => '300',
    'max_input_time' => '300',
    'max_file_uploads' => '20'
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vérification de la configuration PHP</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .ok { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Vérification de la configuration PHP</h2>
    <table>
        <tr>
            <th>Paramètre</th>
            <th>Valeur actuelle</th>
            <th>Valeur attendue</th>
            <th>Statut</th>
        </tr>
        <?php foreach ($expected as $param => $value): ?>
        <tr>
            <td><?php echo htmlspecialchars($param); ?></td>
            <td><?php echo htmlspecialchars($settings[$param]); ?></td>
            <td><?php echo htmlspecialchars($value); ?></td>
            <td class="<?php echo compareValues($settings[$param], $value) === '✅ OK' ? 'ok' : 'error'; ?>">
                <?php echo compareValues($settings[$param], $value); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Informations supplémentaires :</h3>
    <ul>
        <li>Fichier INI chargé : <?php echo htmlspecialchars($settings['loaded_ini_file']); ?></li>
        <li>Version PHP : <?php echo htmlspecialchars($settings['php_version']); ?></li>
        <li>Interface SAPI : <?php echo htmlspecialchars($settings['sapi']); ?></li>
    </ul>

    <h3>Conseils :</h3>
    <ul>
        <li>Si les modifications ne sont pas prises en compte, redémarrez votre serveur web.</li>
        <li>Assurez-vous que le fichier modifié est bien celui chargé par PHP.</li>
        <li>Vérifiez qu'aucun autre fichier de configuration ne surcharge ces valeurs.</li>
    </ul>
</body>
</html>
