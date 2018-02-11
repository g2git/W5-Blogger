$(function() {

  $('#aFilter').click(function() {

    //Get data to be sent to server
    var af = document.getElementById("autFilter");
    var idf = document.getElementById("idFilter");
    var afv = af.value;
    var idfv = idf.value;


    $.ajax({
      type: 'POST',
      url: 'search.php',
      data: {
        authorsearch: afv,
        idsearch: idfv
      },
      success: function(response) {
        $("#readerblogList").html(response);
      },
      error: function(msg) {
        alert("Error: " + msg);
      }
    });
  });


  $('#cFilter').click(function() {

    //Get data to be sent to server
    var cf = document.getElementById("catFilter");
    var cfv = cf.value;

    $.ajax({
      type: 'POST',
      url: 'search.php',
      data: {
        catsearch: cfv
      },
      success: function(response) {
        $("#readerblogList").html(response);
      },
      error: function(msg) {
        alert("Error: " + msg);
      }
    });
  });

  $('#idButton').click(function() {

    //Get data to be sent to server
    var ids = document.getElementById("idSearch");
    var idsv = ids.value;

    $.ajax({
      type: 'POST',
      url: 'search.php',
      data: {
        idsearch: idsv
      },
      success: function(response) {
        $("#readerblogList").html(response);
      },
      error: function(msg) {
        alert("Error: " + msg);
      }
    });
  });


var pc = document.getElementById("postComment");
  $("button").on("click", (function() {


      var fr = $(this).closest("form");

      // Serialize the form data.
      var formData = fr.serialize();


      // Submit the form using AJAX.
      $.ajax({
        type: 'POST',
        url: 'search.php',
        data: formData,
        success: function(response) {
          $("#readerblogList").html(response);
        },
        error: function(msg) {
          alert("Error: " + msg);
        }
      });

    })

  );

  $("#goBack").click(function(event) {
    event.preventDefault();
    history.back(1);
  });

});
