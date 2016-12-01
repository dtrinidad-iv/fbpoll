<?php


$data=array();
$myfile = fopen("admin/config.txt", "r") or die("Unable to open file!");
$postID;
$access_token;
$count = 0;
// Output one line until end-of-file
while(!feof($myfile)) {



  if ($count ==0) {
      $access_token = trim(preg_replace('/\s\s+/', ' ', fgets($myfile)));
  }elseif($count ==1){
    $postID = trim(preg_replace('/\s\s+/', ' ', fgets($myfile)));
    // $postID =  fgets($myfile);

  }else{
    $nothing =  fgets($myfile);
  }

  $count++;
  // array_push($data,fgets($myfile));
}


 ?>
