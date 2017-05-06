function checkchar_space_dot(data)
{
	var checkchar=/^[a-zA-Z. ]+$/;
	
	if(!data.match(checkchar)) {
		
		return false;
	} else {
		
		return true;
	}
}

function checkcontactno(data)
{
	var checkchar=/^[0-9]+$/;
	
	if(!data.match(checkchar)) {
		
		return false;
	} else {
		if ((data.length < 10) || (data.length > 10)) {
			return false;
		} else {
			return true;
		}
	}
}

function checkmail(data)
{
	var checkmail=/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	
	if (!data.match(checkmail)) {
		
		return false;
	} else {
		
		return true;
	}
}

function checkspecialcharacters(data)
{
	var checkchar=/^[a-zA-Z0-9,~`!@$%^*()-_=|{}:;"'<>?.[\/\] ]+$/;
	
	if(!data.match(checkchar)) {
		
		return false;
	} else {
		
		return true;
	}
}

function checkwebaddress(data)
{
	var checkaddress = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
	
	if (!data.match(checkaddress)) {
		
		return false;
	} else {
		
		return true;
	}
}