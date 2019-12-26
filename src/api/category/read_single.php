<?php

/**
 * GET Single category
 * url: /src/api/category/read_single.php?id={id}
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();

/**
 * Instantiate blog category object
 */
$category = new Category($db);

/**
 * Get category ID
 */
$category->id = isset($_GET['id']) ? $_GET['id'] : die('invalid id');

$category->read_single();

$categoryArr = [
    'id' => $category->id,
    'name' => $category->name,
];

print_r(json_encode($categoryArr));
