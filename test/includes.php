<?php

require_once '../src/Errors.php';
require_once '../src/Database.php';
require_once '../src/Validator.php';
require_once '../src/Request.php';

$db = new Database;
$errors = new Errors;

$data = $db->table('users')->exists('username', '=' ,'thomas');

var_dump($data);

if(!empty($_POST)) {

    $validator = new Validator($db, $errors);

    $validation =  $validator->validate($_POST, [
        'username' => [
            'required' => true,
            'max' => 20,
            'min' => 3,
            'alnum' => true,
            'unique' => 'users'
        ],
        'email' => [
            'required' => true,
            'max' => 255,
            'email' => true,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'min' => 6
        ],
        'password_match' => [
            'match' => 'password'
        ]
    ]);

    if($validation->fails()) {
        echo '<pre>', print_r($validation->errors()->get()), '</pre>';
    }
}

