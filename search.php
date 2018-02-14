<?php
include_once('database.php');

session_start();

            //filter by author
        if (isset($_POST['authorsearch'])  && isset($_POST['idFilter'])) {
            $name = $_POST['authorsearch'];
            $authID = $_POST['idFilter'];

            $query = "SELECT title, blogArticle, blogId, category, enable_comment, dateTime FROM blogs WHERE author = '$name' AND authorId = '$authID' ORDER BY dateTime DESC;";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($result->num_rows > 0) {
                echo

                  "<h1>Author: ".$name."</h1>";

                foreach ($row as $k => $v) {
                    echo
                      "<div>
                        <p>Date: ".$v["dateTime"]."</p>
                        <p>Title: ".$v["title"]."</p>
                        <p>Category: ".$v["category"]."</p>
                        <div>".$v["blogArticle"]."</div>";

                    // check if comments enabled

                    if ($v["enable_comment"] == 0) {
                        echo

                        "<div>
                            <p>Post a comment</p>
                            <form id=\"frm\">
                            <input type = \"hidden\" name =\"blogid\" value=".$v["blogId"].">
                            <label><input type=\"checkbox\" name=\"checkbox\" value=\"value1\">Post comment anonymously</label>
                            <textarea name=\"readercomment\" id=\"readercomment\"></textarea>
                            <button type=\"button\" id=\"postComment\" name=\"postComment\">Post comment</button>
                            </form>
                          </div>
                        </div>".



                      // Comments section
                      "<table id = tbl>
                        <tr><td><div><p>Comments</p></div></td></tr>
                        <tr><td><div id=comments>";

                        $blogid2 = $v["blogId"];
                        $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
                        $result2 = mysqli_query($connection, $query2);
                        $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        foreach ($row2 as $k2 => $v2) {
                            echo

                          "<tr><td><div>".$v2["username"].": ".$v2["comment"]."</div></td></tr>";
                        }
                        echo

                    "</div></td></tr>
                    </table>";
                    }
                }

                //end   if ($result->num_rows > 0)
            } else {
                echo "The name and ID you entered did not return any results";
            }
        }

        //search category
        if (isset($_POST['catsearch'])) {
            $category = $_POST['catsearch'];

            $query = "SELECT * FROM blogs WHERE category ='$category'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($result->num_rows > 0) {
                foreach ($row as $k => $v) {
                    echo
                          "<div>
                            <p>Date: ".$v["dateTime"]."</p>
                            <p>Author: ".$v["author"]."</p>
                            <p>Title: ".$v["title"]."</p>
                            <p>Category: ".$v["category"]."</p>
                            <div>".$v["blogArticle"]."</div>";

                    // check if comments enabled

                    if ($v["enable_comment"] == 0) {
                        echo

                            "<div>
                              <p>Post a comment</p>
                              <form id=\"frm\">
                              <input type = \"hidden\" name =\"blogid\" value=".$v["blogId"].">
                              <label><input type=\"checkbox\" name=\"checkbox\" value=\"value1\">Post comment anonymously</label>
                              <textarea name=\"readercomment\" id=\"readercomment\"></textarea>
                              <button type=\"button\" id=\"postComment\" name=\"postComment\">Post comment</button>
                              </form>
                            </div>
                        </div>".



                          // Comments section
                          "<table id = tbl>
                            <tr><td><div><p>Comments</p></div></td></tr>
                            <tr><td><div id=comments>";

                        $blogid2 = $v["blogId"];
                        $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
                        $result2 = mysqli_query($connection, $query2);
                        $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        foreach ($row2 as $k2 => $v2) {
                            echo

                              "<tr><td><div>".$v2["username"].": ".$v2["comment"]."</div></td></tr>";
                        }
                        echo

                        "</div></td></tr>
                        </table>";
                    }
                }
                echo

                        "</div>";
            } else {
                echo "The category you entered did not return any result";
            }
        }

        //search id
        if (isset($_POST['idsearch1'])) {
            $name = $_POST['idsearch1'];

            $query = "SELECT DISTINCT authorId FROM blogs WHERE author ='$name'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($result->num_rows > 0) {
                echo
                "<table>
                    <th>Author: ".$name."</th>";


                foreach ($row as $k => $v) {
                    echo "<tr><td>ID: ".$v["authorId"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "The name you entered did not return any results";
            }
        }

        if (isset($_POST['titlesearch'])) {
            $title = $_POST['titlesearch'];

            //Counter for how many times there matches
            $no_hits = sizeof($title);

            foreach ($title as $t) {

            $query = "SELECT * FROM blogs WHERE title LIKE '%$t%' OR blogArticle LIKE '%$t%'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($result->num_rows > 0) {

                foreach ($row as $k => $v) {
                    echo
                          "<div>
                            <p>Date: ".$v["dateTime"]."</p>
                            <p>Author: ".$v["author"]."</p>
                            <p>Title: ".$v["title"]."</p>
                            <p>Category: ".$v["category"]."</p>
                            <div>".$v["blogArticle"]."</div>";

                    // check if comments enabled

                    if ($v["enable_comment"] == 0) {
                        echo

                            "<div>
                              <p>Post a comment</p>
                              <form id=\"frm\">
                              <input type = \"hidden\" name =\"blogid\" value=".$v["blogId"].">
                              <label><input type=\"checkbox\" name=\"checkbox\" value=\"value1\">Post comment anonymously</label>
                              <textarea name=\"readercomment\" id=\"readercomment\"></textarea>
                              <button type=\"button\" id=\"postComment\" name=\"postComment\">Post comment</button>
                              </form>
                            </div>
                        </div>".



                          // Comments section
                          "<table id = tbl>
                            <tr><td><div><p>Comments</p></div></td></tr>
                            <tr><td><div id=comments>";

                        $blogid2 = $v["blogId"];
                        $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
                        $result2 = mysqli_query($connection, $query2);
                        $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                        foreach ($row2 as $k2 => $v2) {
                            echo

                              "<tr><td><div>".$v2["username"].": ".$v2["comment"]."</div></td></tr>";
                        }
                        echo

                        "</div></td></tr>
                        </table>";
                    }
                }
                echo

                        "</div>";
            } else {
                $no_hits--;
            }
          }

              //if no matches are found
            if ($no_hits == 0)
            {
                echo "The title you searched did not return any results";
            }
        }

        if (isset($_POST['month'])) {
          $month = $_POST['month'];

          $query = "SELECT * FROM blogs WHERE MONTH(dateTime) = '$month' ORDER BY dateTime DESC;";
          $result = mysqli_query($connection, $query);
          $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

          if ($result->num_rows > 0) {
            foreach ($row as $k => $v) {
                echo

                "<div>
                  <p>Date: ".$v["dateTime"]."</p>
                  <p>Author: ".$v["author"]."</p>
                  <p>Title: ".$v["title"]."</p>
                  <p>Category: ".$v["category"]."</p>
                  <div>".$v["blogArticle"]."</div>";

          // check if comments enabled

          if ($v["enable_comment"] == 0) {
              echo

                  "<div>
                    <p>Post a comment</p>
                    <form id=\"frm\">
                    <input type = \"hidden\" name =\"blogid\" value=".$v["blogId"].">
                    <label><input type=\"checkbox\" name=\"checkbox\" value=\"value1\">Post comment anonymously</label>
                    <textarea name=\"readercomment\" id=\"readercomment\"></textarea>
                    <button type=\"button\" id=\"postComment\" name=\"postComment\">Post comment</button>
                    </form>
                  </div>
              </div>".



                // Comments section
                "<table id = tbl>
                  <tr><td><div><p>Comments</p></div></td></tr>
                  <tr><td><div id=comments>";

              $blogid2 = $v["blogId"];
              $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
              $result2 = mysqli_query($connection, $query2);
              $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
              foreach ($row2 as $k2 => $v2) {
                  echo

                    "<tr><td><div>".$v2["username"].": ".$v2["comment"]."</div></td></tr>";
              }
              echo

              "</div></td></tr>
              </table>";
                }
            }
            echo

              "</div>";
            }else{
              echo "No articles found for this month";
            }
          }

        //submit comment
        if (isset($_POST['readercomment'])) {
          if (isset($_SESSION['username']) || isset($_SESSION['bloggername'])){

            $readercomment = mysqli_escape_string($connection, $_POST['readercomment']);
            $blogId1 = $_POST['blogid'];
            $username = $_SESSION['username'];
            $bloggername = $_SESSION['bloggername'];


            //if anonymous box has been checked
            if (isset($_POST['checkbox'])) {
                $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', 'Anonymous');";
                $result1 = mysqli_query($connection, $query1);
                $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
            } else {
              if(isset($_SESSION['username'])){
                $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', '$username');";
                $result1 = mysqli_query($connection, $query1);
                $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
              }else{
                $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', '$bloggername');";
                $result1 = mysqli_query($connection, $query1);
                $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
              }
            }


            $query = "SELECT title, author, blogArticle, blogId, category, enable_comment, dateTime FROM blogs ORDER BY dateTime DESC;";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($row as $k => $v) {
                echo

              // Article data
              "<div>
                <p>Date: ".$v["dateTime"]."</p>
                <p>Author: ".$v["author"]."</p>
                <p>Title: ".$v["title"]."</p>
                <p>Category: ".$v["category"]."</p>
                <div>".$v["blogArticle"]."</div>";


                // check if comments enabled

                if ($v["enable_comment"] == 0) {
                    echo

            "<div>
                <p>Post a comment</p>
                <form id=\"frm\">
                <input type = \"hidden\" name =\"blogid\" value=".$v["blogId"].">
                <label><input type=\"checkbox\" name=\"checkbox\" value=\"value1\">Post comment anonymously</label>
                <textarea name=\"readercomment\" id=\"readercomment\"></textarea>
                <button type=\"button\" id=\"postComment\" name=\"postComment\">Post comment</button>
                </form>
              </div>
            </div>".



            // Comments section
            "<table id = tbl>
              <tr><td><div><p>Comments</p></div></td></tr>
              <tr><td><div id=comments>";

                    $blogid2 = $v["blogId"];
                    $query2 = "SELECT comment, username FROM comments WHERE blogId = '$blogid2';";
                    $result2 = mysqli_query($connection, $query2);
                    $row2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                    foreach ($row2 as $k2 => $v2) {
                        echo

                "<tr><td><div>".$v2["username"].": ".$v2["comment"]."</div></td></tr>";
                    }
                    echo

            "</div></td></tr>
            </table>";
                }
            }
          }else{
            echo "You must be logged in to post comments";
          }
        };


        ?>
