<?php
include_once('database.php');

session_start();
?>


<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>

    </head>

    <body>


        <?php

        if (isset($_POST['submitTitle'])) {
            $name = $_POST['authorsearch'];
            $authID = $_POST['idsearch'];

            $query = "SELECT title, blogArticle, blogId, dateTime FROM blogs WHERE author = '$name' AND authorId = '$authID' ORDER BY dateTime DESC;";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($result->num_rows > 0) {
                ?>

                <!-- filter by Author -->
                <div id="blgList">
                    <table id = tbl>
                        <th><?php echo "Author: ".$name ?></th>
                        <?php


                        $blgidarr=array();
                        foreach ($row as $k => $v) {
                          array_push($blgidarr, $v["blogId"]);
                            ?>
                            <tr><td><?php echo "Date: ".$v["dateTime"]?></td></tr>
                            <tr><td><?php echo "Title: ".$v["title"]?></td></tr>
                            <tr><td><div><?php echo $v["blogArticle"]?></div></td></tr>
                            <tr><td>
                              <div>
                              <p>Post a comment</p>
                            <form method = "POST">
                              <input type = "hidden" name ="blogid" value="<?php echo $v["blogId"]?>">
                              <label><input type="checkbox" name="checkbox" value="value1">Post comment anonymously</label>
                              <textarea name="readercomment" id="readercomment"></textarea>
                              <input type="submit" id="submitComment" name="submitComment" value="Submit comment">
                            </form>
                            </div></td></tr>



                            <!-- Comments section -->
                              <tr><td><div><p>Comments</p></div></td></tr>
                            <tr><td><div id=comments >
                              <?php
                            $blogid2 = $v["blogId"];
                            $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
                            $result2 = mysqli_query($connection, $query2);
                            $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                            foreach ($row2 as $k2 => $v2) {

                                ?>

                                <tr><td><div><?php print_r($v2["username"].": ".$v2["comment"])?></div></td></tr>
<?php
                            } ?>



                            </div></td></tr>
                            <tr><td><div><?php echo ""?></div></td></tr>
                            <tr><td><?php echo ""?></td></tr>
                                        <?php
                        } ?>
                    </table>
</div>
                <?php


//end   if ($result->num_rows > 0)
            } else {
                echo "The name and ID you entered did not return any results";
            }
        }

        //submit comment
        if (isset($_POST['submitComment'])) {
          $readercomment = $_POST['readercomment'];
          $blogId1 = $_POST['blogid'];
          $username = $_SESSION['username'];
          //if anonymous box has been checked
          if (isset($_POST['checkbox'])){

            $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', 'Anonymous');";
            $result1 = mysqli_query($connection, $query1);
            $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

          }else{
            $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', '$username');";
            $result1 = mysqli_query($connection, $query1);
            $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
          }


          };


//search author
        if (isset($_POST['submitId'])) {
            $authId = $_POST['authoridsearch'];

            $query = "SELECT DISTINCT authorId FROM blogs WHERE author ='$authId'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($result->num_rows > 0) {
                ?>
            <div id="blgId">

                <table>
                    <th><?php echo "Author: ".$authId ?></th>
                    <?php

                    foreach ($row as $k => $v) {
                        ?>
                        <tr><td><?php echo "ID: ".$v["authorId"] ?> </td></tr>
                        <?php
                    } ?>
                </table>

            </div>

        <?php
            } else {
                echo "The name you entered did not return any results";
            }
        }


        ?>

        <form id="searchTitle" action="" method="POST">
            Enter author's name:
            <input type="search" name="authorsearch">
            Enter author's id:
            <input type="search" name="idsearch">
            <input type="submit" id="submitTitle" name="submitTitle" value="Search blog">
        </form>



        <form id="searchId" action="" method="POST">
            Search for author's Id:
            <input type="search" name="authoridsearch">
            <input type="submit"  id ="submitId" name="submitId" value="Search id">
        </form>



    </body>
</html>
