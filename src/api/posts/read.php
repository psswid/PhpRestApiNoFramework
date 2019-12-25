<?php

/**
 * GET All Posts
 * url: /src/api/posts/read.php
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();

/**
 * Instantiate blog post object
 */
$post = new Post($db);

/**Blog post query*/
$result = $post->read();
/**Get row count*/
$num = $result->rowCount();

/**Check if any posts*/
if ($num > 0) {
    $postsArr = [];
    // $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row, null);

        $postItem = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        ];

        $postsArr[] = $postItem;
    }

    echo json_encode($postsArr);

} else {
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}
