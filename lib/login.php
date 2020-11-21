<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form


    //$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $myusername = mysqli_real_escape_string($db,$_POST['username']);
    $mypassword = mysqli_real_escape_string($db,$_POST['password']);

    $sql = "SELECT * FROM Users WHERE name = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
        $_SESSION['username'] = $myusername;
        $_SESSION['admin'] = $row['administrator'];
        $_SESSION['ID'] = $row['userID'];
        $_SESSION['condoAssociationID'] = $row['condoAssociationID'];

        $sql = "SELECT groupID FROM groups g, group_membership m WHERE g.groupID = m.gID AND m.uID=". $_SESSION['ID'];
        $result2 = mysqli_query($db,$sql);
        $listofGroups = [];
        while($answer = mysqli_fetch_array($result2)){
            array_push($listofGroups,$answer['groupID']);
        }
        $_SESSION['groupID'] = $listofGroups;

        header("location: welcome.php");

    }else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>
<html>

<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">

</head>

<body bgcolor = "#FFFFFF">

<div align = "center">
    <div style = "width:3000px; border: transparent 1px ; " align = "left">
        <div style = "background-color:#aca3ec; color:#4D39D6; padding:3px;"><b>Login</b></div>

        <div style = "margin:30px">

            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            <form action = "login.php" method = "post">
                <div class="ui two column middle aligned relaxed grid basic segment">
                    <div class="column">
                        <div class="ui form segment AVAST_PAM_loginform">
                            <div class="field">
                                <label>Username</label>
                                <div class="ui left labeled icon input">
                                    <input type="text" placeholder="Username" name = "username" class = "box">
                                    <i class="user icon"></i>
                                    <div class="ui corner label">
                                        <i class="asterisk icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label>Password</label>
                                <div class="ui left labeled icon input">
                                    <input type="password" name = "password" class = "box" >
                                    <i class="lock icon"></i>
                                    <div class="ui corner label">
                                        <i class="asterisk icon"></i>
                                    </div>
                                </div>
                            </div>
                            <input class="ui blue submit button" type = "submit" value = " Login "/><br />
                        </div>
                    </div>
            </form>


        </div>

    </div>

</div>
</body>
</html>
