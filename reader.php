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

      <nav>
        <a href="index.php">Home</a>
        <a href="#" id="goBack">Go Back</a>
      </nav>

      <div id=categoryfilter>

              <div>
                <table>
                  <tr><td></td><td><label>Filter by author</label></td></tr>
                  <tr><td>Name</td><td><input type= "text" name="autFilter" id ="autFilter"></td></tr>
                  <tr><td>ID</td><td><input type= "text" name="idFilter" id ="idFilter"></td></tr>
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
                  <tr><td></td><td><label>Search for author's id</label></td></tr>
                  <tr><td>Name</td><td><input type= "text" name="idsearch1" id ="idsearch1"></td></tr>
                  <tr><td></td><td><input type="button" name="idButton" id ="idButton" value="Search"></td></tr>
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
