<?php
$title = "RSS Feeds";
require_once "header.inc.php";
include_once('simplepie/simplepie.inc');
// Display rss adder
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Intelligent RSS</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="javascript/jquery-1.6.2.min.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
    <div id="masthead">
      <img src="images/logo.png" width="529" height="82" alt="Intelligent RSS">
      <h3>Spend less time scanning and more time reading</h3>
    </div>
    <div id="navigation">
      <a href="">Login and Navigation</a>
    </div>
    <div id="url_submit">
      Add New RSS Feed
      <form action="addrss.php" method="POST">
        Name: <input type="text" name="nameofrss" /><br />
        Url: <input type="text" name="rss" />
        <input type="submit" class="submit_button" name="submit" value="Add RSS feed" />
      </form>
    </div>
  </div>
	<div id="feed_content">
		<div id="subscriptions">
			<h5>Subscriptions</h5>
			<div class="site_name">
		    	<p>Site Name</p>
      </div>
			<div class="site_name">
		    	<p>Site Name</p>
      </div>
			<div class="site_name">
		    	<p>Site Name</p>
      </div>
			<div class="site_name">
		    	<p>Site Name</p>
      </div>
			<div class="site_name">
		    	<p>Site Name</p>
      </div>
			<div class="site_name">
		    	<p>Site Name</p>
      </div>
		</div>
		<div id="articles">
			<h5>Articles</h5>
			<div class="article_item">
				<div class="vote-up"></div>
				<div class="vote-down"></div>
				<p>Article Content information goes here</p>
			</div>
			<div class="article_item">
				<div class="vote-up"></div>
				<div class="vote-down"></div>
				<p>Article content information goes here</p>
			</div>
			<div class="article_item">
				<div class="vote-up"></div>
				<div class="vote-down"></div>
				<p>Article content information goes here</p>
			</div>
			<div class="article_item">
				<div class="vote-up"></div>
				<div class="vote-down"></div>
				<p>Article content information goes here</p>
			</div>
			<div class="article_item">
				<div class="vote-up"></div>
				<div class="vote-down"></div>
				<p>Article content information goes here</p>
			</div>
		</div>
	</div>
	<div id="footer">
		<p>Created by SLAP</p>
	</div>
</div>
<script type="text/javascript">
  function refresh() {
    $("#subscriptions").empty();
    <?php
    // Get all the feeds
    $query = mysql_query("SELECT * FROM `feeds` WHERE `user` = '$username'") or die(mysql_error());

    if(!mysql_num_rows($query)) {
    ?>
      $("#subscriptions").append('<div class="site_name"><p>' +
          'You do not have any rss feeds to pull from.' +
          'You can add rss feeds by entering the url in the link above.' +
          '</p></div>');
    <?php
    }
    else {
      // Get the url of the first object
      while($f = mysql_fetch_object($query)) {
    ?>
      $("#subscriptions").append('<div class="site_name"><p>' +
          '<a href="index.php?id=' + <?= $f->id ?> + '">' + <?= $f->name ?> +
          '</a></p></div>');
    <?php
      }
    }
    ?>
  };
  $(function() {
      refresh();
  });
  $(".submit_button").click(function() {
      alert("You clicked the submit button");
  });
  $("#subscriptions .site_name").click(function() {
  <?php
    $id = 1;
    if(isset($_POST['id']) && ctype_digit($_POST['id'])) {
      $id = $_POST['id'];
    }
    $query = mysql_query("SELECT `url` FROM `feeds` WHERE `id` = '$id'");
    if(!mysql_num_rows($query)) {
      error('That rss feed does not exist');
    }
    $feed = new SimplePie();

    $feed->set_feed_url(mysql_fetch_object($query)->url);
    $sucess = $feed->init();
    if(!$sucess) {
      error('There was an error initializing the feed');
    }

    foreach($feed->get_items() as $item) {
    ?>
    $("#articles").append('<div class="article_item">' +
      <?php
      if($item->get_permalink())
      ?>
				'<div class="vote-up"></div>' +
				'<div class="vote-down"></div>' +
        '<a href="' + <?php echo $item->get_permalink() ?> + '">' +
        <?php echo $item->get_title() ?> +

    <?php
    if($item->get_permalink())
      echo '</a> | ';
    echo $item->get_date('j M Y, g:i a');
    ?> +
    '<p>' + <?php echo $item->get_content() ?> + '</p></div>';
    }
  });
</script>
</body>
</html>
