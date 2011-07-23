<?php
$title = "RSS Feeds";
require_once "header.inc.php";
include_once('simplepie/simplepie.inc');
// Display rss adder
?>

Add New RSS Feed
<form action="addrss.php" method="POST">
Name: <input type="text" name="nameofrss" /><br />
Url: <input type="text" name="rss" />
<input type="submit" name="submit" value="Add RSS feed" />
</form>
<br /><br />
<?php
// Get all the feeds
$query = mysql_query("SELECT * FROM `feeds` WHERE `user` = '$username'") or die(mysql_error());

if(!mysql_num_rows($query)) {
    echo "You do not have any rss feeds to pull from. <br />
    You can add rss feeds by entering the url in the link above.";
}
else {
    // Get the url of the first object
    echo "Your feeds: <br />";
    while($f = mysql_fetch_object($query)) {
        echo '<a href="index.php?id=' . $f->id . '">' . $f->name . '</a><br />';
    }
    echo "<br /><br />";

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
        if($item->get_permalink()) 
            echo '<a href="' . $item->get_permalink() . ':>';
        echo $item->get_title(); 
        if($item->get_permalink())
            echo '</a> | ';
        echo $item->get_date('j M Y, g:i a');
        echo "<br />" . $item->get_content() . "<br /><br />";
    }
}
// Parse them using simplepie
// display them
?>
