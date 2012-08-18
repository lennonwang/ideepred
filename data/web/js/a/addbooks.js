$("docunment").ready(function(){
	
});

function editAddress(addId){
	console.log(addId); 
	$.get('/app/eshop/profile/editAddbooks',{id:addId})
}

