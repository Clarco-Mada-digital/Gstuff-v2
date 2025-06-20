<?php

return [
    'profile_type' => [
        'required' => 'The profile type is required.',
        'in' => 'The selected profile type is invalid.',
    ],
    'email' => [
        'required' => 'The email address is required.',
        'email' => 'The email must be a valid email address.',
        'unique' => 'The email has already been taken.',
    ],
    'password' => [
        'required' => 'The password is required.',
        'confirmed' => 'The password confirmation does not match.',
        'min' => 'The password must be at least :min characters.',
    ],
    'date_naissance' => [
        'required' => 'The date of birth is required.',
        'date' => 'The date of birth is not a valid date.',
        'before' => 'You must be at least 18 years old to register.',
    ],
    'cgu_accepted' => [
        'accepted' => 'You must accept the terms and conditions.',
    ],
    'pseudo' => [
        'required_if' => 'The username is required for guest profile.',
        'string' => 'The username must be a string.',
        'max' => 'The username may not be greater than :max characters.',
    ],
    'prenom' => [
        'required_if' => 'The first name is required for escort profile.',
        'string' => 'The first name must be a string.',
        'max' => 'The first name may not be greater than :max characters.',
    ],
    'genre_id' => [
        'required_if' => 'The gender is required for escort profile.',
        'exists' => 'The selected gender is invalid.',
    ],
    'nom_salon' => [
        'required_if' => 'The salon name is required for salon profile.',
        'string' => 'The salon name must be a string.',
        'max' => 'The salon name may not be greater than :max characters.',
    ],
    'intitule' => [
        'required_if' => 'The title is required for salon profile.',
        'in' => 'The selected title is invalid.',
    ],
    'nom_proprietaire' => [
        'required_if' => 'The owner name is required for salon profile.',
        'string' => 'The owner name must be a string.',
        'max' => 'The owner name may not be greater than :max characters.',
    ],
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute must be a string.',
    'email' => 'The :attribute must be a valid email address.',
    'max' => [
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'array' => 'The :attribute must be an array.',
    'exists' => 'The selected :attribute is invalid.',
    'attributes' => [
        'pseudo' => 'username',
        'email' => 'email address',
        'password' => 'password',
        'roles' => 'roles',
    ],
];
