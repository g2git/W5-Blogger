$(function() {

  $('#aFilter').click(function() {
    $('.blogs').show();
    //Get data to be sent to server
    var af = document.getElementById("autFilter");
    var afv = af.value;

    $('.blogs').each(function() {

      if ($(this).children().eq(0).text() !== "Author: " + afv) {
        $(this).hide();
      };

    });

  });


  $('#cFilter').click(function() {
    $('.blogs').show();
    //Get data to be sent to server
    var cf = document.getElementById("catFilter");
    var cfv = cf.value;

    $('.blogs').each(function() {

      if ($(this).children().eq(3).text() !== "Category: " + cfv) {
        $(this).hide();
      };

    });

  });

  $('#titleButton').click(function() {

    //Get data to be sent to server
    var ts = document.getElementById("titleSearch");
    var tsv = ts.value;

    if (tsv !== "") {
      tsv = tsv.toLowerCase();
      var arr = tsv.split(" ");

      $.ajax({
        type: 'POST',
        url: 'search.php',
        data: {
          titlesearch: arr
        },
        success: function(response) {
          var res = $.parseJSON(response);
          $('.blogs').show();

          $(".blogs").each(function() {
            var txt = $(this).attr("id");
            if ($.inArray(txt, res) == -1) {
              $(this).hide();
            }
          })
        },
        error: function(msg) {
          alert("Error: " + msg);
        }
      });
    }
  });


  $("#monthButton").click(function(e) {
    var mData = $("#Month").val();

    $.ajax({
      type: 'POST',
      url: 'search.php',
      data: {
        month: mData
      },
      success: function(response) {
        var res = $.parseJSON(response);
        $('.blogs').show();

        $(".blogs").each(function() {
          var txt = $(this).attr("id");
          if ($.inArray(txt, res) == -1) {
            $(this).hide();
          }
        })
      },
      error: function(msg) {
        console.log("Error: " + msg);
      }
    });
  });


  $(".postComment").on("click", function() {
    var fr = $(this).closest("form");
    var comment = fr.find("input").eq(1).val();
    var formData = fr.serialize();

    //Submit the form using AJAX.
    $.ajax({
      type: 'POST',
      url: 'search.php',
      data: formData,
      success: function(response) {
        $("#" + comment).append(response);

      },
      error: function(msg) {
        alert("Error: " + msg);
      }
    });

  });

  $("#goBack").click(function(event) {
    event.preventDefault();
    history.back(1);
  });

});
