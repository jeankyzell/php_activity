<?php
session_start();

function getUsers() {
    $file = __DIR__ . '/../users.json';
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
        return [];
    }
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    return is_array($users) ? $users : [];
}

function saveUsers($users) {
    $file = __DIR__ . '/../users.json';
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
}

function findUser($username) {
    $users = getUsers();
    foreach ($users as $user) {
        if (strcasecmp($user['username'], $username) === 0) {
            return $user;
        }
    }
    return null;
}

function addUser($username, $email, $phone, $password) {
    $users = getUsers();
    $users[] = [
        'username' => $username,
        'email'    => $email,
        'phone'    => $phone,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created'  => date('Y-m-d H:i:s')
    ];
    saveUsers($users);
}
?>