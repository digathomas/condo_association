<!DOCTYYPE html>
<html>
<head>
    <title>
        Comments Example Page
    </title>
    <script src="comments.js"></script>
    <link href="theme.css" rel="stylesheet">
</head>
<body>
<div style = "background-color:#aca3ec; height:100px; color:#4D39D6; padding:3px;"><b><br><i class="huge chess rook icon"></i></b><b align="middle" style="margin-bottom:10px; color:white; font-size:40px;">CON</b></div>
<?php
include("lib/config.php");
session_start();
$post = $_POST['postid'];
$sql = "SELECT * FROM post WHERE postID=" . $post;
$result = mysqli_query($db, $sql);

while($temp = mysqli_fetch_array($result)){
    echo "<h1>" . $temp['title']."</h1><br>";
    echo "<h2> Posted on: " . $temp['timestamp']. "</h2>";
    $sql = "SELECT name FROM `groups` g, post p WHERE (p.postID =". $temp['postID'] . " and p.groupID = g.groupID)";
    $y = mysqli_query($db, $sql);
    $nameOfGroup = mysqli_fetch_array($y);
    if($temp['perm'] == "public"){
        echo "<h2>Public</h2>";
    }
    elseif ($temp['perm'] == "private"){
        echo "<h2>Private</h2>";
    }
    elseif($temp['perm'] == "Ad"){
        echo "<h2>Ad</h2>";
    }
    else{
        echo "<h2> Group: " . $nameOfGroup['name'] . "</h2>";
    }
    echo "<p>" . $temp['body'] . "</p><br>";
    $prefix = '../';
    $img = preg_replace('/^' . preg_quote($prefix, '/') . '/','', $temp['img']);
    echo "<img onerror='this.onerror=null; this.remove();' src=". $img . " height='200px'; width='400px'><br>";
}

?>

<!--<p>Hello world! This is a comments demo.</p>
<p>This should be your blog post, product page, or whichever that you want to add comments.</p>
-->
<!-- GIVE YOUR PAGE OR PRODUCT A POST ID -->
<input type="hidden" id="post_id" value="<?php echo $post;?>"/>

<!-- CREATE A CONTAINER TO LOAD COMMENTS -->
<div id="comments"></div>

<!-- CREATE A CONTAINER TO LOAD REPLY DOCKET -->
<div id="reply-main"></div>
</body>
</html>