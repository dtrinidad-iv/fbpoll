  <?php include "/includes/header.php" ?>
  <?php include "/admin/readconfig.php"; ?>
<?php
  require_once __DIR__ . '../../vendor/autoload.php';
  include "admin/config.php";
  use Facebook\FacebookRequest;

  session_start();
  $fb = new Facebook\Facebook([
    'app_id' => APP_ID,
    'app_secret' => APP_SECRET,
    'default_graph_version' => 'v2.7',
    ]);



    $fbApp  = new Facebook\FacebookApp(APP_ID, APP_SECRET, 'v2.7');




    try {

          $requestxx = new FacebookRequest(
            $fbApp,
            $access_token,//page access token
            'GET',
            '/' . $postID . '?fields=description,embed_html,stream_url,title'
          );

          $responset = $fb->getClient()->sendRequest($requestxx);
          $json = json_decode($responset->getBody());
          $embed_html = $json->embed_html;
          $embed_html = str_replace("1364","600",$embed_html);
          $embed_html = str_replace("768","400",$embed_html);
          $stream_key = substr($json->stream_url,37);
          $description = $json->description;
          $title = $json->title;

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }


 ?>


      <br><br><br>

    <div class="container">
      <div class="col-xs-10 col-xs-offset-1 in-box">
        <div class="title-card">
          Facebook Live
        </div>

        <div class="in-form">

          <form class="form-inline">

            <a class="btn btn-primary btn-back" href="admin/index.php">Back to Admin Page</a>
            <div class="col-xs-12 no-pad">
              <div class="form-group col-xs-6">
                <label for="accessToken">Access Token </label>
                <input type="text" class="form-control vid-title" name="accessToken" value="<?php echo $access_token ?>" id="accessToken" placeholder="Enter Access Token" readonly>
              </div>
              <div class="form-group col-xs-6">
                <label for="accessToken">Post ID </label>
                <input type="number"  name="postID"  class="form-control vid-title" id="postID" value="<?php echo $postID ?>" placeholder="Enter Post ID" readonly>
              </div>
            </div>
          </form>
          <div style="clear:both;"></div>
          <hr>
          <div class="row">
              <div class="col-xs-12 main-vid">
                  <?php echo $embed_html ?><hr>
              </div>
              <div class="col-xs-12">
                <div class="col-xs-6">
                  <b>Post Description: </b><?php echo $description . "<br>" ?>
                  <b>Video Title:</b> <?php echo $title . "<br>" ?>
                </div>
                <?php if(isset($stream_key)) {?>
                  <div class="col-xs-6">
                       <div class="input-group">
                        <span class="input-group-btn">
                            <label for="accessToken" class="btn btn-secondary"> <b>Stream Key</b></label>
                        </span>

                        <input  class="form-control" id="streamKey" width="100%" value="<?php if(isset($stream_key)) echo $stream_key ?>" readonly>
                         <span class="input-group-btn">
                             <button class="btn" data-clipboard-target="#streamKey"><span class="glyphicon glyphicon-copy"></span></button>
                         </span>
                       </div>
                  </div>
                  <?php } ?>
              </div>
          </div>

          <hr>

            <img height="50px" src="../emojis/like.png" alt=""> <input id="like" value=" <?php echo 'http://'.$_SERVER['HTTP_HOST'] .'/fblive/ulols/react_like.php';  ?>" readonly>
            <button class="btn" data-clipboard-target="#like"><span class="glyphicon glyphicon-copy"></span></button>



            <img height="50px" src="../emojis/love.png" alt=""> <input id="love" value=" <?php echo 'http://'.$_SERVER['HTTP_HOST'] .'/fblive/ulols/react_love.php';  ?>" readonly>
            <button class="btn" data-clipboard-target="#love"><span class="glyphicon glyphicon-copy"></span></button>


            <img height="50px" src="../emojis/haha.png" alt=""> <input id="haha" value=" <?php echo 'http://'.$_SERVER['HTTP_HOST'] .'/fblive/ulols/react_haha.php';  ?>" readonly>
            <button class="btn" data-clipboard-target="#haha"><span class="glyphicon glyphicon-copy"></span></button>
            <hr>


            <img height="50px" src="../emojis/shock.png" alt=""> <input id="wow" value=" <?php echo 'http://'.$_SERVER['HTTP_HOST'] .'/fblive/ulols/react_wow.php';  ?>" readonly>
            <button class="btn" data-clipboard-target="#wow"><span class="glyphicon glyphicon-copy"></span></button>

            <img height="50px" src="../emojis/sad.png" alt=""> <input id="sad" value=" <?php echo 'http://'.$_SERVER['HTTP_HOST'] .'/fblive/ulols/react_sad.php';  ?>" readonly>
            <button class="btn" data-clipboard-target="#sad"><span class="glyphicon glyphicon-copy"></span></button>


            <img height="50px" src="../emojis/angry.png" alt=""> <input id="angry" value=" <?php echo 'http://'.$_SERVER['HTTP_HOST'] .'/fblive/ulols/react_angry.php';  ?>" readonly>
            <button class="btn" data-clipboard-target="#angry"><span class="glyphicon glyphicon-copy"></span></button>

            </div>
        </div>
    </div>

    <script>
        var btns = document.querySelectorAll('button');
        var clipboard = new Clipboard(btns);
        clipboard.on('success', function(e) {
          setTooltip(e.trigger, 'Copied!');
          hideTooltip(e.trigger);
        });
        clipboard.on('error', function(e) {
          setTooltip(e.trigger, 'Failed!');
          hideTooltip(e.trigger);
        });

        // Tooltip

      $('button').tooltip({
        trigger: 'click',
        placement: 'bottom'
      });

      function setTooltip(btn, message) {
        $(btn).tooltip('hide')
          .attr('data-original-title', message)
          .tooltip('show');
      }

      function hideTooltip(btn) {
        setTimeout(function() {
          $(btn).tooltip('hide');
        }, 1000);
      }


        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>



  </body>
</html>
