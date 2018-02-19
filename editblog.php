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
        <a href="signup.html">Sign up</a>
        <a href="#" id="goBack">Go Back</a>
      </nav>

    <?php


//submit blog edits
    if (isset($_POST['editBlog'])) {
        $blogid = $_POST["e_blogid"];
        $authorName = $_SESSION['bloggername'];
        $authorid = $_SESSION['bloggerid'];
        $title = $_POST["e_title"];
        $blogArticle = mysqli_escape_string($connection,$_POST["e_blogArticle"]);
        $category = $_POST["e_category"];

        $sql = "UPDATE blogs SET title = '$title', category = '$category', blogArticle = '$blogArticle' WHERE blogId = '$blogid';";
        $result = mysqli_query($connection, $sql);

        redirect_to("blog.php");

    }

    if(isset($_POST['edit'])){
?>

                <div id="wrapper">

                    <form  method="POST">
                        <input type="hidden" name="e_blogid" value = <?php echo $_POST["edit_blogid"]?>>
                        <label for="title">Title</label>
                        <input type="text" name="e_title" value = "<?php echo $_POST['edit_title'] ?>"><br>
                        <label for="category">Category</label>
                        <input type="text" name="e_category" value = "<?php echo $_POST['edit_category'] ?>"><br>
                        <label for="blogArticle">Write your blog here</label>
                        <input type="textarea" id="text" name="e_blogArticle" value = "<?php echo $_POST['edit_blogArticle'] ?>">
                        <input type="submit" name="editBlog" value="Save Changes">
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

                </div>

                <?php

                }

                  function redirect_to($newlocation)
                  {
                      header("Location: ". $newlocation);
                      exit;
                  }
                  ?>
