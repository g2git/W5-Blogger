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
        <?php if(isset($_SESSION['bloggername'])) {echo "<a href=\"blog.php\">My Admin</a>";}?>
        <a href="login.php">Log in</a>
        <a href="signup.php">Sign up</a>
        <a href="#" id="goBack">Go Back</a>
      </nav>

      <div id=wrapper>
      <div id=categoryfilter>

              <div>
                <table>
                  <tr><td><input type= "text" name="autFilter" id ="autFilter" placeholder="Filter by author"></td></tr>
                  <tr><td><input type="button" name="aFilter" id ="aFilter" value="Filter"></td></tr>
                </table>
              </div>

              <div>
                <table>
                  <tr><td><input type= "text" name="catFilter" id ="catFilter" placeholder="Filter by category"></td></tr>
                  <tr><td><input type="button" name="cFilter" id ="cFilter" value="Filter"></td></tr>
                </table>
              </div>

              <div>
                <table>
                  <tr><td><input type= "text" name="titleSearch" id ="titleSearch" placeholder="Search for keywords"></td></tr>
                  <tr><td><input type="button" name="titleButton" id ="titleButton" value="Search"></td></tr>
                </table>
              </div>

              <div>
                  <table>
                  <tr><td><label>Filter by month</label></td></tr>
                  <tr><td>
                    <select class="dropdown" name="Month" id ="Month">
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
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

                    $counter = 0;

                    $query = "SELECT *, DATE_FORMAT(dateTime, '%M %d %Y %r') as date FROM blogs ORDER BY dateTime DESC;";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($row as $k => $v) {
                      $counter++
                        ?>

                        <!-- Article data -->
                        <div class="blogs" id="blog<?php echo $v["blogId"]?>">
                          <p><?php echo "Author: ".$v["author"]?></p>
                          <p><?php echo "Date: ".$v["date"]?></p>
                          <p><?php echo "Title: ".$v["title"]?></p>
                          <p><?php echo "Category: ".$v["category"]?></p>
                          <div id = "Article"><?php echo $v["blogArticle"]?></div>


                        <!-- check if comments enabled -->
                          <?php
                            if ($v["enable_comment"] == 0) {
                                ?>

                        <!-- post a comment -->
                          <div>
                            <form id="frm">
                              <input type = "hidden" name ="blogid" value="<?php echo $v["blogId"]?>">
                              <input type = "hidden" name ="commentcount" value="commentscontainer<?php echo $counter ?>">
                              <label><input type="checkbox" name="checkbox" value="value1">Post comment anonymously</label>
                              <textarea name="readercomment" id="readercomment" placeholder="Post a comment"></textarea>
                              <input type="button" class="postComment" name="postComment" value="Post comment">
                            </form>
                          </div>




                        <!-- Comments section -->
                        <div id="commentsection">
                        <table id = tbl>
                          <tr><td><p>Comments</p></td></tr>
                          <tr><td><div id = "commentscontainer<?php echo $counter ?>" >
                          <?php
                                $blogid2 = $v["blogId"];
                                $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
                                $result2 = mysqli_query($connection, $query2);
                                $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                                foreach ($row2 as $k2 => $v2) {
                                    ?>

                            <div id = "comments"><?php print_r($v2["username"].": ".$v2["comment"])?></div>

                            <?php
                                } ?>
                          </div></td></tr>
                        </table>
                      </div>
                      </div>
                          <?php
                        }else{

                          ?>
                          <p>Commenting has been disabled</p>
                        </div>
                        <?php
                        }
                    }
                            ?>
                          </div>

                      </body>
                      </html>
