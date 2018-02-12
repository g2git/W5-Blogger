<?php
include_once('database.php');

session_start();
?>


<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script src="reader.js"></script>

    </head>

    <body>


        <?php

        $query = "SELECT title, blogArticle, blogId, category, enable_comment, dateTime FROM blogs ORDER BY dateTime DESC;";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            ?>
            <div id=categoryfilter>
              <div>
                <label>Filter by category<input type= "text" name="catfilter" id ="catfilter"></label>
                <input type="button" name="cFilter" id ="cFilter" value="Filter">
              </div>

            </div>

            <!-- show all blogs -->
            <div id="readerblogList">
                    <?php

                    foreach ($row as $k => $v) {
                        ?>
                        <div class ="<?php echo $v["category"]?>">
                          <input type = "hidden" name="cat" id="cat" value="<?php echo $v["category"]?>">
                        <p><?php echo "Date: ".$v["dateTime"]?></p>
                      <p><?php echo "Title: ".$v["title"]?></p>
                        <p><?php echo "Category: ".$v["category"]?></p>
                        <div><?php echo $v["blogArticle"]?></div>

                        <!-- check if comments enabled -->
                        <?php
                        if($v["enable_comment"] == 0){
                          ?>

                          <div>
                          <p>Post a comment</p>
                        <form method = "POST">
                          <input type = "hidden" name ="blogid" value="<?php echo $v["blogId"]?>">
                          <label><input type="checkbox" name="checkbox" value="value1">Post comment anonymously</label>
                          <textarea name="readercomment" id="readercomment"></textarea>
                          <input type="submit" id="submitComment" name="submitComment" value="Submit comment">
                        </form>
                        </div>
                      </div>



                        <!-- Comments section -->
                        <table>
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

                      }
                        } ?>



                        </div></td></tr>
                        <tr><td><div><?php echo ""?></div></td></tr>
                                    <?php
                    } ?>
                </table>
</div>
            <?php



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

  ?>


    </body>
</html>
