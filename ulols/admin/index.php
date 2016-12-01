  <?php include "../includes/header.php" ?>
  <?php include "config.php"; ?>

      <br><br><br>

      <?php
      require_once __DIR__ . "../../../vendor/autoload.php";
      use Facebook\FacebookRequest;
      session_start();

      $fb = new Facebook\Facebook([
        'app_id' => APP_ID,
        'app_secret' => APP_SECRET,
        'default_graph_version' => 'v2.5',
        ]);


      $helper = $fb->getRedirectLoginHelper();

      $permissions = ['email','manage_pages','publish_pages']; // Optional permissions


      $loginUrl = $helper->getLoginUrl( "http://" . $_SERVER['HTTP_HOST'] .  "/fblive/ulols/admin/fb-callback.php", $permissions);

       ?>

    <div class="container">
      <div class="col-xs-6 col-xs-offset-3 in-box">
        <div class="title-card">
          Facebook Live
        </div>

        <div class="in-form">
          <?php if(isset($_GET['page_access'])){ ?>
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-success">Successfully Generated a New <b><?php echo $_GET['page'] ?></b> Page Access Token for <b><?php echo $_GET['user'] ?>!</b></div>
              </div>
            </div>
          <?php } ?>
        
          <form action="setconfig.php" method="post" class="form-inline">
            <div class="form-group col-xs-6 no-pad">
              <input type="text" class="form-control readonly gen-token" name="accessToken" value="<?php if(isset($_GET['page_access'])) echo $_GET['page_access'] ?>" id="accessToken" placeholder="Page Access Token Here" required >
            </div>
            <!-- <div class="form-group">
              <label for="accessToken">Post ID</label>
              <input type="number"  name="postID" value="<?php if(isset($_GET['post_id'])) echo $_GET['post_id'] ?>"  class="form-control" id="postID" placeholder="Enter Post ID">
            </div> -->
            <?php  echo '<a  class="col-xs-5 col-xs-offset-1 btn btn-danger"  href="' . htmlspecialchars($loginUrl) . '">Generate Token</a>'; ?>
            
            <div style="clear:both;"></div>
            <hr>

            <div class="form-group col-xs-12 no-pad">
              <textarea type="text" class="form-control vid-title" name="videoTitle" id="videoTitle" placeholder="Video Title Here" required></textarea>
            </div>
            <div class="form-group col-xs-12 no-pad">
              <textarea type="text" class="form-control vid-desc" name="postDescription" id="postDescription" placeholder="Post Description Here" required></textarea>
            </div>

            <button type="submit" class="col-xs-5 col-xs-offset-7 btn btn-primary margin-bot">Create Live Video</button>

                    <!-- <a class="btn btn-warning" href="../index.php">URL's Page</a> -->
                    <!-- <a class="btn btn-info" href="https://developers.facebook.com/" target="_blank">FB DEV</a> -->
          </form>
        </div>

      <!-- <?php if(isset($_GET['stream_url'])) {?>
        <div class="col-lg-6">
             <div class="input-group">
              <span class="input-group-btn">
                  <label for="accessToken" class="btn btn-secondary"> <b>Stream Key</b></label>
              </span>
              <input  class="form-control" id="streamKey"  value="<?php if(isset($_GET['stream_url'])) echo $_GET['stream_url'] ?>" readonly>
               <span class="input-group-btn">
                   <button class="btn" data-clipboard-target="#streamKey"><span class="glyphicon glyphicon-copy"></span></button>
               </span>
             </div>
        </div>
        <?php } ?> -->

      </div>
    </div>




      <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>



        <script>
          $(".readonly").keydown(function(e){
              e.preventDefault();
          });
       </script>

  </body>
</html>
