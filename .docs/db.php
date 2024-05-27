<?php

/**
 * Scripts pour appliquer les contraintes de la base de donnes
 */

define('SEP', DIRECTORY_SEPARATOR);

// executer seulement le code en ligne de commande !
$IS_SERVER = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
if (!empty($IS_SERVER)) die("ce code doit etre executer dans la ligne de commande !\n");

$fichier_sql = dirname(__DIR__, 1) . SEP . '_.constraint.sql';
$fichier_contenu = file_get_contents($fichier_sql);

// ressources de connexion !
$database = array(
    'host' => 'localhost',
    'dbname' => 'dbiphonesapp',
    'user' => 'abou',
    'password' => 'abou@89'
);

$conn = pg_connect("host={$database['host']} dbname={$database['dbname']} user={$database['user']} password={$database['password']}");
$init_db = pg_exec($conn, $fichier_contenu);

if ($init_db) die("Applications des contraintes terminer avec success !!! \n");
else {
    var_dump($init_db);
    die("Erreur pour l'initialisation de la base de donnee \n");
}
