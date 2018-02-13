$(function() {

  $('#subB').click(function() {

    //Get data to be sent to server
    var af = document.getElementById("autFilter");
    var idf = document.getElementById("idFilter");
    var afv = af.value;
    var idfv = idf.value;


    $.ajax({
      type: 'POST',
      url: 'signup.php',
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
});
