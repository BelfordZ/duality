$(document).ready(
    function() {
	initChat();
    });

textToSend = "";
pathToServer = "http://localhost/~bawllz/test1.php";

function initChat()
{
    make_async(pathToServer+"?refresh=true", "chatHolder");
    setInterval(step, 1000);
}

function step()
{
    make_async(pathToServer+"?refresh=true"+"\n", "chatHolder");
    textToSend = "";
}

function sendText()
{
    textToSend += document.getElementById("textBox").value;
    make_async(pathToServer+"?textToSend="+textToSend+"&refresh=false" +"\n", "chatHolder");
}

function load_content_done(req, url, targ)
{
	if (req.readyState == 4 && req.status == 200)
	{ 
		document.getElementById(targ).innerHTML += req.responseText;
	}
}
function load_content(url, target)
{
	var req;
	if (window.XMLHttpRequest)
	{
		req = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (req !== undefined)
	{
	    req.onreadystatechange = function()
	    {
		load_content_done(req, url, target);
	    }
	

			req.open("GET", url, true);
			req.send();
	
	}
}
function make_async(name, div)
{
    load_content(name, div);
}