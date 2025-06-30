<?php

return [
    'validation' => [
        'name_required' => 'Der Tag-Name ist erforderlich.',
        'name_string' => 'Der Name muss eine Zeichenkette sein.',
        'name_max' => 'Der Name darf nicht länger als :max Zeichen sein.',
        'name_unique' => 'Dieser Tag-Name wird bereits verwendet.',
    ],
    'success' => [
        'tag_created' => 'Tag erfolgreich erstellt.',
        'tag_updated' => 'Tag erfolgreich aktualisiert.',
        'tag_deleted' => 'Tag erfolgreich gelöscht.',
    ],
    'error' => [
        'tag_not_found' => 'Tag nicht gefunden.',
    ]
];
