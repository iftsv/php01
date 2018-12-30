function auth(){
  var login = $("#login").val();
  var pass = $("#pass").val(); 
  var str = "login="+login+"&pass="+pass;
  
  $.ajax({
    type: 'POST',
    url: 'server.php',
    data: str,
    success: function(data_answer){
                $("h1").html(data_answer);
             }
  });
};