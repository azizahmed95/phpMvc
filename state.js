
function getState(val) {
  //alert(val);
  $.ajax({
  type: "POST",
  url: "get_states.php",
  data:'language_id='+val,
  success: function(data){
    $("#state").html(data);
  }
  });
}

function getCity(val) {
  //alert(val);
  $.ajax({
  type: "POST",
  url: "get_cities.php",
  data:'language_id='+val,
  success: function(data){
    $("#city").html(data);
  }
  });
}

function getTehsil(val) {
  //alert(val);
  $.ajax({
  type: "POST",
  url: "get_tehsil.php",
  data:'language_id='+val,
  success: function(data){
    $("#tehsil").html(data);
  }
  });
}

function setLink(value)
{
  //alert(value);
   $.ajax({
      type: "POST",
      dataType: "html",
      url: "links.php",
      data: {
        "key":value
      },
      
      success: function(data) {
         $("#d1").html(data);

      }

  })
}