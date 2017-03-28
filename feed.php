<?php
include_once('GetTwitterFeed.class.php');


$retrieveUrl = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=xyluz";
$consumer_key = "12u86gn9yvvkcYFRm3lsWcYz7";
$consumer_key_secret = "iKjf5T621LAkVk65NX3Jt9TTlJifSnnccpdEZd9HolscYXvEBF";
$objTwitter = new GetTwitterFeed($retrieveUrl, $consumer_key, $consumer_key_secret);

 $raw_feed = json_decode($objTwitter->getJsonFeed(),TRUE);
$counter = 0;
foreach($raw_feed as $feed){

$strip_feed = $feed[$counter]['extended_entities']['media'][0]['video_info']['variants'];

//loop
//print_r($feed[0][extended_entities][media][0][video_info][variants]);

echo "<!html><head><title>Twitter Video Downloader</title></head><body>";

foreach($strip_feed as $strip){

echo " <video width='320' height='240' controls>
  <source src='" . $strip['url'] . "' type='" . $strip['content_type'] . "'>
 
Your browser does not support the video tag.
</video> <br>";

echo "<a href='" . $strip['url'] ."'>" . $strip['content_type']."</a>";

}

echo "</body></html>";
}

?>
