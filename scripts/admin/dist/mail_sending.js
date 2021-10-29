'use strict'
var template;
var total	=	contacts.length;
var send = 0;
var success = 0;
var failed = 0;

var progress	=	$('<div>',{
	class : 'progress-bar progress-bar-green',
	role : 'progressbar',
	'aria-valuenow' : 0,
	'aria-valuemin' : 0,
	'aria-valuemax' : total,
	css : {width: '0%'}
});

$('#progress').html(progress);

$( '#sendMail' ).on('click',function(){
	template = {
		greeting : $('#greeting').val(),
		content : $('#content').val(),
		subject : $('#subject').val(),
	}
	$('#progessBox').slideDown();
	$('#composeBox').slideUp();
	$('#contactsShowButton').click();
	$.each(contacts, function(index, contact) {
	    send_mail(contact);
	});
});

function send_mail(contact){
	
	var data = {
		template : template,
		contact : contact
	}
	$('#mailResult').html('Sending to : '+contact.contact_name + '( '+contact.contact_email+' ) .....');
	$.ajax({
		url : base + 'contacts/send_mail_to_contact',
		data : data ,
		method : 'post',
		success : function(result){
			success++;
			updateProgress();
			
		},
		fail : function(result){
			failed++;
			updateProgress();
		}
	});

}

function updateProgress()
{
	send++;
	var width	=	(total/send)*100;
	progress.css({width : width+'%' });
	$('#progress').html(progress);
	$('#mailResult').html('Send : '+send +'<br/>Succeess : '+success +'<br/>Failed : '+failed);
}