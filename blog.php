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

    <?php

    if(isset($_POST['submitBlog'])) {

        $authorName = $_POST["author"];
        $authorID = $_POST["authorId"];
        $title = $_POST["title"];
        $blogArticle = $_POST["blogArticle"];
      //  $password = $_POST["authorPsw"];


        $sql = "INSERT INTO blogs (author, authorId, title, blogArticle)
          VALUES ('$authorName', '$authorID','$title', '$blogArticle')";

        $result = mysqli_query($connection, $sql);


            ?><div><p><?php echo "Your blog has been posted"?></p></div>
    <?php

        }


/*        else {
                    */?><!--<div><p><?php /*echo "Failed to upload blog"*/?></p></div>
            --><?php
/*            }*/
        ?>



                <div id="wrapper">

                    <form  method="POST">
                        <label for="author">Please enter your name here</label>
                        <input type="text" name="author"><br>
                        <label for="authorId">Enter your id here</label>
                        <input type="text" name="authorId"><br>
                        <label for="title">Title</label>
                        <input type="text" name="title"><br>
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

            </body>

</html>
