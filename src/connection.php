<?php

$pdo = new PDO('mysql:dbname=serenatto;host=localhost', 'root', '');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);