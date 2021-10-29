$(document).ready(function(){
    
    $("#add_email").click(function(){
    var row="";  
    row+="<div class='form-group'><input type=text class='form-control' value=''  name='contact_email[]'' ></div>";
    
    $('#emails').append(row);

    });



     $("#add_phone").click(function(){
    var row="";  
    row+="<div class='form-group'><input type=text class='form-control' value=''  name='contact_phone[]'' ></div>";
    
    $('#phones').append(row);

    });
});
