<?php

include_once 'database.php';

session_start();
?>

<html>

    <head>

        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script src="blog.js"></script>

    </head>

    <body>

      <nav>
        <a href="index.php">Home</a>
        <a href="#" id="goBack">Go Back</a>
      </nav>

    <?php


//submit Blog
    if (isset($_POST['submitBlog'])) {
        $authorName = $_POST["author"];
        $authorID = $_POST["authorId"];
        $title = $_POST["title"];
        $blogArticle = $_POST["blogArticle"];
        $category = $_POST["category"];


        $sql = "INSERT INTO blogs (author, authorId, title, category, blogArticle)
          VALUES ('$authorName', '$authorID','$title', '$category', '$blogArticle')";

        $result = mysqli_query($connection, $sql); ?><div><p><?php echo "Your blog has been posted"?></p></div>
    <?php
    }
        ?>



                <div id="wrapper">

                    <form  method="POST">
                        <label for="author">Please enter your name here</label>
                        <input type="text" name="author"><br>
                        <label for="authorId">Enter your id here</label>
                        <input type="text" name="authorId"><br>
                        <label for="title">Title</label>
                        <input type="text" name="title"><br>
                        <label for="category">Category</label>
                        <input type="text" name="category"><br>
                        <label for="blogArticle">Write your blog here</label>
                        <input type="textarea" id="text" name="blogArticle">
                        <input type="submit" name="submitBlog" value="Submit blog">
                    </form>

                    <div id = "shortcuts" hidden>
                      <form>
                          <table id="myTable">
                            <tr>
                              <td>
                                <textarea name="abbreviation" placeholder="Abbreviation" id="abbreviation"></textarea>
                              </td>
                              <td>
                                <textarea name="expand_to" placeholder="Expand to" id="expand_to"></textarea>
                              </td>
                            </tr>
                          </table>

                          <div>
                      <input type="button" id="more_fields" value="Add More"/>
                      <input type="button" id ="apply" value="Apply">
                    </div>

                                      </form>
                                      </div>
                  <div>
                  <input type = "button" id="toggle" value="Edit Abbreviations">
                                  </div>

                                  <div>
                  <?php
                  $bloggername =$_SESSION['bloggername'];

                  $query1 = "SELECT blogId, title, blogArticle, blogId, category, enable_comment, dateTime FROM blogs WHERE author = '$bloggername' ORDER BY dateTime DESC;";
                  $result1 = mysqli_query($connection, $query1);
                  $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);

                      ?>

                      <!-- filter by Author -->
                      <div id="blgList">
                              <h2>My Articles</h2>
                              <?php

                              foreach ($row1 as $k => $v) {
                                  ?>

                                  <!-- Article data -->
                                  <p><?php echo "Date: ".$v["dateTime"]?></p>
                                  <p><?php echo "Title: ".$v["title"]?></p>
                                  <p><?php echo "Category: ".$v["category"]?></p>
                                  <div><?php echo $v["blogArticle"]?></div>


                                  <!-- check if comments enabled -->
                                  <?php
                                  if ($v["enable_comment"] == 0) {
                                      ?>




                                    <form>
                                      <p>Post a comment</p>
                                      <input type = "hidden" name ="blogid" value="<?php echo $v["blogId"]?>">
                                      <label><input type="checkbox" name="checkbox" value="value1">Post comment anonymously</label>
                                      <textarea name="readercomment" id="readercomment"></textarea>
                                      <input type="button" id="postComment" name="postComment" value="Post comment">
                                    </form>


                                    <!-- Disable comments -->
                                     <div>
                                       <form method = "POST">
                                       <input type = "hidden" name ="commentenable" value="<?php echo $v["blogId"]?>">
                                       <label><input type="checkbox" name="commentcheckbox" value="value2">Disable commenting</label>
                                       <input type="submit" id="submitcbox" name="submitcbox" value="Apply">
                                       </form>
                                     </div>



                                  <!-- Comments section -->
                                  <table id = tbl>
                                    <tr><td><div><p>Comments</p></div></td></tr>
                                  <tr><td><div id=comments >
                                    <?php
                                  $blogid2 = $v["blogId"];


                                      $query2 = "SELECT id, comment, username FROM comments WHERE blogId = '$blogid2';";
                                      $result2 = mysqli_query($connection, $query2);
                                      $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);


                                      // Display comment
                                      foreach ($row2 as $k2 => $v2) {
                                          ?>
                                    <tr><td><div>
                                        <form method = "POST">
                                        <input type = "hidden" name ="commentid" value="<?php echo $v2["id"]?>">
                                        <p><?php print_r($v2["username"].": ".$v2["comment"])?></p>
                                        <input type="submit" id="deleteComment" name="deleteComment" value="Delete comment">
                                      </form>
                                    </div>
                                  </td></tr>



                            <?php
                                      } ?>
                      </div></td></tr>
                      </table>

                          <?php
                                  };
                              }
                        ?>


                      </div>

                      <?php
                          //submit comment
                          if (isset($_POST['submitComment'])) {
                              $readercomment = $_POST['readercomment'];
                              $blogId1 = $_POST['blogid'];
                              $username = $_SESSION['username'];


                              //if anonymous box has been checked
                              if (isset($_POST['checkbox'])) {
                                  $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', 'Anonymous');";
                                  $result1 = mysqli_query($connection, $query1);
                                  $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                              } else {
                                  $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', '$username');";
                                  $result1 = mysqli_query($connection, $query1);
                                  $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                              }
                          };



                          //delete comment
                          if (isset($_POST['deleteComment'])) {
                              $commentid = $_POST['commentid'];

                              $query4 = "DELETE FROM comments WHERE id = '$commentid';";
                              $result4 = mysqli_query($connection, $query4);
                              $row4 = mysqli_fetch_all($result4, MYSQLI_ASSOC);
                          };

                          if (isset($_POST['commentcheckbox']) && isset($_POST['submitcbox'])) {
                              $blogid5 = $_POST['commentenable'];
                              $query5 = "UPDATE blogs SET enable_comment = '1' WHERE blogId = '$blogid5';";
                              $result5 = mysqli_query($connection, $query5);
                              $row5 = mysqli_fetch_all($result5, MYSQLI_ASSOC);
                          }

                          ?>
      </div>

                </div>

            </body>

</html>
