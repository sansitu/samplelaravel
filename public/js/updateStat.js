//var BASEURL = 'http://bms:9090';
//var BASEURL = 'http://santoshmohapatra.online';
var result = 0;
var BASEURL = '';

function timedCount() {
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		   // Typical action to be performed when the document is ready:
		   result = xhttp.responseText;
		}
	};
	xhttp.open("GET", BASEURL + '/getStat', true);
	xhttp.send();

    postMessage(result);
    setTimeout("timedCount()",5000);
}

self.addEventListener('message', function(e) {
  BASEURL = e.data['BASEURL'];
  //self.postMessage(e.data['BASEURL']);
  timedCount();
}, false);
