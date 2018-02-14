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
        <a href="login.php">Log in</a>
        <a href="signup.html">Sign up</a>
        <a href="#" id="goBack">Go Back</a>
      </nav>

    <?php


//submit Blog
    if (isset($_POST['submitBlog'])) {
        $authorName = $_SESSION['bloggername'];
        $authorID = $_SESSION['bloggerid'];
        $title = $_POST["title"];
        $blogArticle = mysqli_escape_string($connection, $_POST["blogArticle"]);
        $category = $_POST["category"];


        $sql = "INSERT INTO blogs (author, authorId, title, category, blogArticle)
          VALUES ('$authorName', '$authorID','$title', '$category', '$blogArticle')";

        $result = mysqli_query($connection, $sql); ?><div><p><?php echo "Your blog has been posted"?></p></div>
    <?php
    }
        ?>



                <div id="wrapper">

                    <form  method="POST">
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
                  //Show my articles
                  $bloggername =$_SESSION['bloggername'];
                  $authorid = $_SESSION['bloggerid'];

                  $query1 = "SELECT blogId, title, blogArticle, category, enable_comment, dateTime FROM blogs WHERE author = '$bloggername' AND authorId ='$authorid' ORDER BY dateTime DESC;";
                  $result1 = mysqli_query($connection, $query1);
                  $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);



                      ?>

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

                                  <div>
                                      <form  method="POST" action="editblog.php">
                                        <input type="hidden" name="edit_blogid" value = <?php echo $v["blogId"]?>>
                                        <input type="hidden" name="edit_title" value = <?php echo $v["title"]?>>
                                        <input type="hidden" name="edit_category" value = <?php echo $v["category"]?>>
                                        <input type="hidden" name="edit_blogArticle" value = <?php echo $v["blogArticle"]?>>
                                        <input type="submit" name="edit" value="Edit blog">
                                      </form>
                                  </div>

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

                                      //query for comments
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
                              $bloggername = $_SESSION['bloggername'];


                              //if anonymous box has been checked
                              if (isset($_POST['checkbox'])) {
                                  $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', 'Anonymous');";
                                  $result1 = mysqli_query($connection, $query1);
                                  $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                              } else {
                                  $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', '$bloggername');";
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
