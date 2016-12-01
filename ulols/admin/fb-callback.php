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

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(APP_ID); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}

//  GET USER INFO
  try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=id,name,picture', $accessToken);
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }

  $user = $response->getGraphUser();

  echo '<h3>User Info </h3>';
  echo 'Name: ' . $user['name'] . '</br>';
  echo 'Picture: ' . $user['picture']['url'];



    $_SESSION['fb_access_token'] = (string) $accessToken;

    $fbApp  = new Facebook\FacebookApp(APP_ID, APP_SECRET, 'v2.7');

    $requestxx = new FacebookRequest(
      $fbApp,
      $_SESSION['fb_access_token'],//my user access token
      'GET',
      '/' . PAGE_ID . '?fields=access_token,name',
      // '/me/accounts',
      array('ADMINISTER')
    );
    $responset = $fb->getClient()->sendRequest($requestxx);
    $json = json_decode($responset->getBody());
    $page_access = $json->access_token;
    $page_name = $json->name;

    echo '<h3>Page Access Token</h3>';
    print_r($page_access);
    //
    // if (isset($_GET['x'])) {
    //   die(var_dump($_GET['x']));
    // }


    // //Post property to Facebook
    // $linkData = [
    //  'description' => 'post description',
    //  'title' => 'post title here'
    // ];
    //
    // try {
    //  $response = $fb->post('/' .PAGE_ID . '/live_videos', $linkData, $page_access);
    // } catch(Facebook\Exceptions\FacebookResponseException $e) {
    //  echo 'Graph returned an error: '.$e->getMessage();
    //  exit;
    // } catch(Facebook\Exceptions\FacebookSDKException $e) {
    //  echo 'Facebook SDK returned an error: '.$e->getMessage();
    //  exit;
    // }
    //
    // $graphNode = $response->getGraphNode();
    // $post_id = $graphNode->getField('id');
    // $stream_id = substr(str_replace("&","%26",$graphNode->getField('stream_url')),37);
    //
    // echo '<h3>LIVE VIDE POST ID</h3>';
    // print_r($post_id . '<br>');
    // print_r($stream_id  . '<br>');

    // die(var_dump($graphNode));


// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
    // header("Location:" . "http://" . $_SERVER['HTTP_HOST'] .  "/fblive/ulols/admin/index.php?page_access=" . $page_access . '&user=' . $user['name']. '&page=' . $page_name . '&post_id=' . $post_id . '&stream_url=' . $stream_id);
    header("Location:" . "http://" . $_SERVER['HTTP_HOST'] .  "/fblive/ulols/admin/index.php?page_access=" . $page_access . '&user=' . $user['name']. '&page=' . $page_name);

 ?>
