function isJson(Value){
	var ToReturn = true;
	try{
		var json = $.parseJSON(Value);
	}
	catch(err){
		ToReturn = false;
	}
	return ToReturn;
}