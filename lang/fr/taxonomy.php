<?php

return [
    // Interface
    'taxonomy_management' => 'Gestion des Taxonomies',
    'new_category' => '+ Nouvelle Catégorie',
    'new_tag' => '+ Nouveau Tag',
    'categories' => 'Catégories',
    'tags' => 'Tags',
    'name' => 'Nom',
    'articles' => 'Articles',
    'actions' => 'Actions',
    'edit' => 'Éditer',
    'delete' => 'Supprimer',
    'confirm_delete' => 'Confirmer la suppression',
    'confirm_delete_message' => 'Êtes-vous sûr de vouloir supprimer',
    'category' => 'cette catégorie',
    'tag' => 'ce tag',
    'irreversible_action' => '? Cette action est irréversible.',
    'delete_button' => 'Supprimer',
    'cancel_button' => 'Annuler',
    'save_button' => 'Enregistrer',
    'category_name' => 'Nom',
    'category_description' => 'Description',
    'tag_name' => 'Nom du tag',
    'edit_category' => 'Modifier la catégorie',
    'create_category' => 'Créer une catégorie',
    'edit_tag' => 'Modifier le tag',
    'create_tag' => 'Créer un tag',
    'no_categories_found' => 'Aucune catégorie trouvée',
    'no_tags_found' => 'Aucun tag trouvé',
    'status' => 'Statut',
    'active' => 'Actif',
    'inactive' => 'Inactif',
    'toggle_status' => 'Changer le statut',
    
    // Success messages
    'category_created' => 'Catégorie créée avec succès',
    'category_updated' => 'Catégorie mise à jour avec succès',
    'category_deleted' => 'Catégorie supprimée avec succès',
    'tag_created' => 'Tag créé avec succès',
    'tag_updated' => 'Tag mis à jour avec succès',
    'tag_deleted' => 'Tag supprimé avec succès',
    'status_updated' => 'Statut mis à jour avec succès',
    
    // Error messages
    'category_not_found' => 'Catégorie non trouvée',
    'tag_not_found' => 'Tag non trouvé',
    'delete_error' => 'Une erreur est survenue lors de la suppression',
    'update_error' => 'Une erreur est survenue lors de la mise à jour',
    'validation' => [
        'name_exists' => 'Une catégorie avec ce nom existe déjà.',
    ],
    'create_error' => 'Une erreur est survenue lors de la création',
    
    // Validation
    'validation' => [
        'name_required' => 'Le nom est requis',
        'name_max' => 'Le nom ne doit pas dépasser :max caractères',
        'name_unique' => 'Ce nom est déjà utilisé',
        'name_exists' => 'Une catégorie avec ce nom existe déjà.',
        'description_string' => 'La description doit être une chaîne de caractères',
        'id_required' => 'L\'identifiant est requis',
        'id_exists' => 'L\'identifiant spécifié n\'existe pas',
        'lang_required' => 'La langue est requise',
        'lang_in' => 'La langue sélectionnée n\'est pas valide',
    ],
    
    // Form fields
    'fields' => [
        'name' => 'nom',
        'description' => 'description',
        'language' => 'langue',
    ],
];
