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
        idFilter: idfv
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
    var ids = document.getElementById("idsearch1");
    var idsv = ids.value;

    $.ajax({
      type: 'POST',
      url: 'search.php',
      data: {
        idsearch1: idsv
      },
      success: function(response) {
        $("#readerblogList").html(response);
      },
      error: function(msg) {
        alert("Error: " + msg);
      }
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
          $("#readerblogList").html(response);
        },
        error: function(msg) {
          alert("Error: " + msg);
        }
      });
    }
  });

  // $('form').one("submit", submitFormFunction);
  //
  // function submitFormFunction(event) {
  //     event.preventDefault();
  //     $('form').submit();
  // }

  //var pc = document.getElementById("postComment");
  $("button").on("click", function() {
    //  $('form').submit(function(event) {
    // $('form').one("submit", function(event) {
    // Stop the browser from submitting the form.
    //event.preventDefault();
    //console.log($("#postComment"));

    var fr = $(this).closest("form");

    // Serialize the form data.
    var formData = fr.serialize();
    // var formData = $(this).serialize();
    //console.log(formData);

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

  });

  $("#goBack").click(function(event) {
    event.preventDefault();
    history.back(1);
  });

});
