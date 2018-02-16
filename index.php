<?php
include_once('database.php');

session_start();
?>


<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script src="index.js"></script>

    </head>

    <body>

      <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Log in</a>
        <a href="signup.php">Sign up</a>
        <a href="#" id="goBack">Go Back</a>
      </nav>

      <div id=categoryfilter>

              <div>
                <table>
                  <tr><td></td><td><label>Filter by author</label></td></tr>
                  <tr><td>Name</td><td><input type= "text" name="autFilter" id ="autFilter"></td></tr>
                  <tr><td></td><td><input type="button" name="aFilter" id ="aFilter" value="Filter"></td></tr>
                </table>
              </div>

              <div>
                <table>
                  <tr><td></td><td><label>Filter by category</label></td></tr>
                  <tr><td>Category</td><td><input type= "text" name="catFilter" id ="catFilter"></td></tr>
                  <tr><td></td><td><input type="button" name="cFilter" id ="cFilter" value="Filter"></td></tr>
                </table>
              </div>

              <div>
                <table>
                  <tr><td></td><td><label>Search for title</label></td></tr>
                  <tr><td>Title</td><td><input type= "text" name="titleSearch" id ="titleSearch"></td></tr>
                  <tr><td></td><td><input type="button" name="titleButton" id ="titleButton" value="Search"></td></tr>
                </table>
              </div>

              <div>
                  <table>
                  <tr><td><label>Filter by month</label></td></tr>
                  <tr><td>
                    <select class="dropdown" name="Month" id ="Month">
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maart</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Augustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select></td></tr>
                  <tr><td><input type="button" name= "monthButton" id = "monthButton" value="Filter"></td></tr>
                  </table>
              </div>

            </div>

            <!-- show all blogs -->
            <div id="readerblogList">
                    <?php

                    $query = "SELECT title, author, blogArticle, blogId, category, enable_comment, dateTime FROM blogs ORDER BY dateTime DESC;";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($row as $k => $v) {
                        ?>

                        <!-- Article data -->
                        <div>
                          <p><?php echo "Author: ".$v["author"]?></p>
                          <p><?php echo "Date: ".$v["dateTime"]?></p>
                          <p><?php echo "Title: ".$v["title"]?></p>
                          <p><?php echo "Category: ".$v["category"]?></p>
                          <div><?php echo $v["blogArticle"]?></div>


                        <!-- check if comments enabled -->
                          <?php
                            if ($v["enable_comment"] == 0) {
                                ?>

                          <div>
                              <p>Post a comment</p>
                              <form id="frm">
                              <input type = "hidden" name ="blogid" value="<?php echo $v["blogId"]?>">
                              <label><input type="checkbox" name="checkbox" value="value1">Post comment anonymously</label>
                              <textarea name="readercomment" id="readercomment"></textarea>
                              <button type="button" id="postComment" name="postComment">Post comment</button>
                            </form>
                          </div>
                      </div>



                        <!-- Comments section -->
                        <table id = tbl>
                          <tr><td><div><p>Comments</p></div></td></tr>
                          <tr><td><div id=comments>
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
                        </table>
                          <?php
                            }
                    }
                            ?>

                          </div>
                          <?php

  ?>


    </body>
</html>
