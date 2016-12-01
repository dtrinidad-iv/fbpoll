<?php

require_once __DIR__ . '../../../vendor/autoload.php';
include "config.php";
use Facebook\FacebookRequest;
session_start();
$fb = new Facebook\Facebook([
  'app_id' => APP_ID,
  'app_secret' => APP_SECRET,
  'default_graph_version' => 'v2.7',
  ]);


  $accessToken = $_POST["accessToken"];
  // $postID = $_POST["postID"];
  $postDescription = $_POST["postDescription"];
  $videoTitle = $_POST["videoTitle"];

  //Post property to Facebook
  $linkData = [
   'description' => $postDescription,
   'title' => $videoTitle
  ];

  try {
   $response = $fb->post('/' .PAGE_ID . '/live_videos', $linkData, $accessToken);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
   echo 'Graph returned an error: '.$e->getMessage();
   exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
   echo 'Facebook SDK returned an error: '.$e->getMessage();
   exit;
  }

  $graphNode = $response->getGraphNode();
  $post_id = $graphNode->getField('id');
  $stream_id = substr(str_replace("&","%26",$graphNode->getField('stream_url')),37);

  echo '<h3>LIVE VIDE POST ID</h3>';
  print_r($post_id . '<br>');
  print_r($stream_id  . '<br>');



    $myfile = fopen("config.txt", "w") or die("Unable to open file!");
    $txt =   $accessToken . "\n";
    fwrite($myfile, $txt);
    $txt = $post_id . "\n";
    fwrite($myfile, $txt);
    fclose($myfile);


  header("Location:" . "http://" . $_SERVER['HTTP_HOST'] .  "/fblive/ulols/index.php");

?>
