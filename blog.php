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
        <a href="blog.php">My Admin</a>
        <a href="login.php">Log in</a>
        <a href="signup.php">Sign up</a>
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
                                <input type ="text" name="abbreviation" placeholder="Abbreviation" id="abbreviation">
                              </td>
                              <td>
                                <input type ="text" name="expand_to" placeholder="Expand to" id="expand_to">
                              </td>
                              </tr>
                              <tr>
                              <td>
                                <input type="button" id="more_fields" value="Add More">
                              </td>
                              </tr>
                              <tr>
                              <td>
                                <input type="button" id="apply" value="Apply">
                              </td>
                            </tr>
                          </table>
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

                  $query1 = "SELECT *, DATE_FORMAT(dateTime, '%M %d %Y %r') as date FROM blogs WHERE author = '$bloggername' AND authorId ='$authorid' ORDER BY dateTime DESC;";
                  $result1 = mysqli_query($connection, $query1);
                  $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);



                      ?>

                      <div id="blgList">
                              <h2>My Articles</h2>
                              <?php

                              foreach ($row1 as $k => $v) {
                                $counter++
                                  ?>

                                  <!-- Article data -->
                                  <div class="blogs" id="blog<?php echo $v["blogId"]?>">
                                  <p><?php echo "Date: ".$v["date"]?></p>
                                  <p><?php echo "Title: ".$v["title"]?></p>
                                  <p><?php echo "Category: ".$v["category"]?></p>
                                  <div><?php echo $v["blogArticle"]?></div>

                                  <div>
                                      <form  method="POST" action="editblog.php">
                                        <input type="hidden" name="edit_blogid" value = "<?php echo $v["blogId"]?>">
                                        <input type="hidden" name="edit_title" value = "<?php echo $v["title"]?>">
                                        <input type="hidden" name="edit_category" value = "<?php echo $v["category"]?>">
                                        <input type="hidden" name="edit_blogArticle" value = "<?php echo $v["blogArticle"]?>">
                                        <input type="submit" name="edit" value="Edit blog">
                                      </form>
                                  </div>

                                  <!-- check if comments enabled -->
                                  <?php
                                  if ($v["enable_comment"] == 0) {
                                      ?>



                                      <!-- post a comment -->
                                  <div>
                                    <form>
                                      <input type = "hidden" name ="blogid" value="<?php echo $v["blogId"]?>">
                                      <input type = "hidden" name ="commentcount" value="commentscontainer<?php echo $counter ?>">
                                      <label><input type="checkbox" name="checkbox" value="value1">Post comment anonymously</label>
                                      <textarea name="readercomment" id="readercomment" placeholder="Post a comment"></textarea>
                                      <input type="button" class="postComment" name="postComment" value="Post comment">
                                    </form>
                                  </div>

                                    <!-- Disable comments -->
                                     <div>
                                       <form method = "POST">
                                       <input type = "hidden" name ="commentdisable" value="<?php echo $v["blogId"]?>">
                                       <label><input type="checkbox" name="commentcheckbox" value="value2">Disable commenting</label>
                                       <input type="submit" id="submitcbox" name="submitcbox" value="Apply">
                                       </form>
                                     </div>



                                  <!-- Comments section -->
                                  <div id="commentsection">
                                  <table id = tbl>
                                    <tr><td><p>Comments</p></td></tr>
                                    <tr><td><div id = "commentscontainer<?php echo $counter ?>" >
                                    <?php
                                      $blogid2 = $v["blogId"];

                                      //query for comments
                                      $query2 = "SELECT id, comment, username FROM comments WHERE blogId = '$blogid2';";
                                      $result2 = mysqli_query($connection, $query2);
                                      $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);


                                      // Display comment
                                      foreach ($row2 as $k2 => $v2) {
                                          ?>
                                        <tr><td>
                                        <form method = "POST">
                                        <input type = "hidden" name ="commentid" id = "commentid" value="<?php echo $v2["id"]?>">
                                        <div class = "bcomments" id="bcomments<?php echo $v2["id"]?>">
                                          <?php print_r($v2["username"].": ".$v2["comment"])?> <p class="deleteComment">&#10008;
                                          <span class="tooltiptext">Delete comment</span></p>
                                        </div>
                                      </form>
                                  </td></tr>



                            <?php
                                      } ?>
                      </div></td></tr>
                      </table>
                    </div>
                      </div>
                          <?php
                                  }else{

                                    ?>

                                    <!-- Enable comments -->
                                    <div>
                                      <p>Commenting has been disabled</p>
                                      <form method = "POST">
                                        <input type = "hidden" name ="commentenable" value="<?php echo $v["blogId"]?>">
                                        <input type="submit" id="submitecbox" name="submitecbox" value="Enable comments">
                                      </form>
                                     </div>
                                  </div>
                                  <?php
                                  }
                              }
                        ?>
                      </div>

                      <?php


                          //Disable commenting
                          if (isset($_POST['commentcheckbox']) && isset($_POST['submitcbox'])) {
                              $blogid5 = $_POST['commentdisable'];
                              $query5 = "UPDATE blogs SET enable_comment = '1' WHERE blogId = '$blogid5';";
                              $result5 = mysqli_query($connection, $query5);
                          }


                          //Enable commenting
                          if (isset($_POST['submitecbox'])) {
                              $blogid6 = $_POST['commentenable'];
                              $query6 = "UPDATE blogs SET enable_comment = '0' WHERE blogId = '$blogid6';";
                              $result6 = mysqli_query($connection, $query6);
                          }

                          ?>
                        </div>

                </div>

            </body>

</html>
