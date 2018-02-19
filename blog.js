$(function() {

  var table = document.getElementById("myTable");

  shortcuts = {};

  $('#toggle').click(function() {
    $('#shortcuts').toggle()
  });

  $('#more_fields').click(function() {
    var abbval = document.getElementById("abbreviation");
    var expval = document.getElementById("expand_to");
    if (abbval.value !== "") {
      shortcuts[abbval.value] = expval.value;
      var row = table.insertRow(0).innerHTML = '<tr><td><textarea name ="abbreviation" placeholder="Abrreviation" id="abbreviation"></textarea></td><td><textarea name="expand_to" placeholder ="Expand to" id="expand_to"></textarea></td></tr>';
    }
  });

  $('#apply').click(function() {
    var abbval = document.getElementById("abbreviation");
    var expval = document.getElementById("expand_to");
    if (abbval.value !== "") {
      shortcuts[abbval.value] = expval.value;
    }

    $('#shortcuts').hide()
  });



  var ta = document.getElementById("text");
  var timer = 0;


  update = function() {
    if (!isEmpty(shortcuts)) {
      var re = new RegExp("\\b(" + Object.keys(shortcuts).join("|") + ")\\b", "g");
      ta.value = ta.value.replace(re, function($0, $1) {
        return shortcuts[$1.toLowerCase()];
      })
    }
  };


  ta.onkeydown = function() {
    clearTimeout(timer);
    timer = setTimeout(update, 200);

  }


  function isEmpty(obj) {
    for (var key in obj) {
      if (obj.hasOwnProperty(key))
        return false;
    }
    return true;
  };

  $(".deleteComment").click(function() {
    if (confirm("Are you sure you wish to delete this comment?")) {
      var fr = $(this).closest("form");
      var com_id = fr.find("input").eq(0).val();


      //Submit the form using AJAX.
      $.ajax({
        type: 'POST',
        url: 'search.php',
        data: {commentid : com_id},
        success: function(response) {
          $("#bcomments" + com_id).hide();
        },
        error: function(msg) {
          alert("Error: " + msg);
        }
      });


    } else {}
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
