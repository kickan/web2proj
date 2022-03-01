<?php
include_once("../includes/config.php");

#Headers
header("content-type: application/json; utf-8");

#create new post obj
$postapi = new Post;

#Get 3 latest posts
$response = $postapi->getPosts(3);

echo json_encode($response);