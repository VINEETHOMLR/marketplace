

$(document).ready(function(){
    
    $("#addnew").click(function(){
    var row="";  
    row+='<div class="col-md-4">';
    row+='<div class="form-group ma0 mb10">';
    row+='<select class="form-control" name="social_id[]">';
    row+='<option value=0>Select</option>';
    $.each(JSON.parse(socialmedia), function(i, item) {
    row+='<option value='+i+'>'+item+'</option>';
    });
    row+='</select>';
    row+='</div></div>';
    row+='<div class="col-md-4">';
    row+='<div class="form-group ma0 mb10">';
    row+='<input type="text" class=" form-control " value="" name="social_link[]" placeholder="Social media link">';
    row+='</div>';
    row+='</div>';
    row+='<div class="col-md-4">';
    row+='<div class="form-group ma0 mb10">';
    row+='<select class="form-control" name="social_status[]">';
    row+='<option value=0>Select</option>';
    $.each(JSON.parse(status), function(i, item) {
    row+='<option value='+i+'>'+item+'</option>';
    });
    row+='</select>';
    row+='</div>';
    row+='<input type="hidden" value="" name="id[]">';
    row+='</div>';
    $('#socialsettings').append(row);

    });
});

