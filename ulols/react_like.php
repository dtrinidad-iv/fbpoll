		<?php require("includes/header.php") ?>

    <!-- REACTIONS -->
		<div class="tc wf likes"><span class="counter">0</span></div>
    <!-- <div class="tc wf love"><span class="counter"></span></div> -->
    <!-- <div class="tc wf sad"><img class="emoji" src="emojis/sad.png"><span class="counter"></span></div> -->
    <!-- <div class="tc wf haha"><img class="emoji" src="emojis/haha.png"><span class="counter"></span></div>
    <div class="tc wf angry"><img class="emoji" src="emojis/angry.png"><span class="counter"></span></div>
    <div class="tc wf wow"><img class="emoji" src="emojis/shock.png"><span class="counter"></span></div> -->


		    <script src="../jquery.min.js"></script>
		    <script src="../lodash.min.js"></script>
    <script>

    "use strict";
		// var access_token = '1501028386578973|Z4OvmuEXPLWhteRiFWBp00V0L2k'; // PASTE HERE YOUR FACEBOOK ACCESS TOKEN
		// var access_token = 'EAAVVLWfHoh0BAHyZBVSxaxNewZBwkqZAroRoN6YaZC7XZBhAtBZCG6PKacYVZAwQWTZCkMyerjeZA7CRedMqjMdY5TDS1icpZCi3jGh0p8dkg6oXq3YwpA0dG9MscCk8Xf9uoj9xoOjCJPEHxZAhZCLmHZABpXpEnmvAIZCumNpdvZC3ZCxaK8tl5WuG1dJQ'; // PASTE HERE YOUR FACEBOOK ACCESS TOKEN
    // var postID = '163434047459013'; // PASTE HERE YOUR POST ID
    var refreshTime = 1; // Refresh time in seconds
    var defaultCount = 0; // Default count to start with

    var reactions = ['LIKE', 'LOVE', 'WOW', 'HAHA', 'SAD', 'ANGRY'].map(function (e) {
        var code = 'reactions_' + e.toLowerCase();
        return 'reactions.type(' + e + ').limit(0).summary(total_count).as(' + code + ')'
    }).join(',');

    var	v1 = $('.likes .counter'),
    		v2 = $('.love .counter'),
        v3 = $('.sad .counter'),
        v4 = $('.haha .counter'),
        v5 = $('.angry .counter'),
        v6 = $('.wow .counter');

    function refreshCounts() {
        var url = 'https://graph.facebook.com/v2.8/?ids=' + postID + '&fields=' + reactions + '&access_token=' + access_token;
	    	$.getJSON(url, function(res){
	    		v1.text(defaultCount + res[postID].reactions_like.summary.total_count);
	    		v2.text(defaultCount + res[postID].reactions_love.summary.total_count);
	        v3.text(defaultCount + res[postID].reactions_sad.summary.total_count);
	        v4.text(defaultCount + res[postID].reactions_haha.summary.total_count);
	        v5.text(defaultCount + res[postID].reactions_angry.summary.total_count);
	        v6.text(defaultCount + res[postID].reactions_wow.summary.total_count);
	    	});
    }

    $(document).ready(function(){
        setInterval(refreshCounts, refreshTime * 1000);
        refreshCounts();
    });
    </script>
</body>
</html>
