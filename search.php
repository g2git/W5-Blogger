<?php
include_once('database.php');

session_start();

        //Search by keywords
        if (isset($_POST['titlesearch'])) {
            $title = $_POST['titlesearch'];

            foreach ($title as $t) {

            $query = "SELECT * FROM blogs WHERE title LIKE '%$t%' OR blogArticle LIKE '%$t%'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $arr = array();

                foreach ($row as $k => $v) {

                    array_push($arr, "blog".$v["blogId"]);

                }

          }
            echo json_encode($arr);
        }

        //Filter by month
        if (isset($_POST['month'])) {
          $month = $_POST['month'];

          $query = "SELECT * FROM blogs WHERE MONTH(dateTime) = '$month' ORDER BY dateTime DESC;";
          $result = mysqli_query($connection, $query);
          $row = mysqli_fetch_all($result, MYSQLI_ASSOC);


          $arr = array();

              foreach ($row as $k => $v) {
                  array_push($arr, "blog".$v["blogId"]);
              }
          echo json_encode($arr);
          }


        //submit comment
        if (isset($_POST['readercomment'])) {
          if (isset($_SESSION['username']) || isset($_SESSION['bloggername'])){

            $rc = htmlentities($_POST['readercomment']);
            $readercomment = mysqli_escape_string($connection, $rc);
            $blogId1 = $_POST['blogid'];
            $username = $_SESSION['username'];
            $bloggername = $_SESSION['bloggername'];
            $c_name = (isset($_SESSION['username'])) ? $username : $bloggername;
            $c_response = (isset($_SESSION['username'])) ? "<div id = \"comments\">$c_name: $rc</div>" :  "<div class = \"bcomments\">$c_name: $rc";

            //if anonymous box has been checked
            if (isset($_POST['checkbox'])) {
                $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', 'Anonymous');";
                $result1 = mysqli_query($connection, $query1);
            } else {
                $query1 = "INSERT INTO comments (comment, blogId, username) VALUES ('$readercomment', '$blogId1', '$c_name');";
                $result1 = mysqli_query($connection, $query1);
              }

             echo $c_response;

          }else{
            ?><script>alert("You must be logged in to post comments")</script><?php
        };
        }


        //delete comment
        if (isset($_POST['commentid'])) {
            $commentid = $_POST['commentid'];

            $query4 = "DELETE FROM comments WHERE id = '$commentid';";
            $result4 = mysqli_query($connection, $query4);
        };

        ?>
