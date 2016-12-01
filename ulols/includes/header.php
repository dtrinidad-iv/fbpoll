
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>FB LIVE ULOLS</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="../../css/style.css" rel="stylesheet">
	<script src="../dist/clipboard.min.js"></script>
	<script src="../../dist/clipboard.min.js"></script>


</head>
<body>
    <header>

					<?php
						  $textfile_url = file_exists("admin/config.txt") ? "admin/config.txt" : "../admin/config.txt";
							$myfile = fopen($textfile_url, "r") or die("Unable to open file!");
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

        <link rel="stylesheet" href="../css/style.css">
				<script type="text/javascript">
						var access_token = "<?php echo $access_token;?>"; // PASTE HERE YOUR FACEBOOK ACCESS TOKEN
						var postID = <?php echo  $postID; ?>; // PASTE HERE YOUR POST ID


				</script>

				<?php 		fclose($myfile); ?>
    </header>
