<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$whitelist = [
    '127.0.0.1',
    '::1'
];

if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    header('Location: /');
    exit();
}
phpinfo();
