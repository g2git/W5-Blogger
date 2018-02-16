$(function() {

  $("#emailButton").on("click", function() {

    var fr = $("#recForm").serialize();
    // Submit the form using AJAX.
    console.log(fr);
    $.ajax({
      type: 'POST',
      url: 'send_link.php',
      data: fr,
      success: function(response) {
        $("#Recovery").append(response);
      },
      error: function(msg) {
        alert("Error: " + msg);
      }
    });

  });

});
