function index_init()
{
	make_async("form_login.php", "loginWrap");
	make_async('home.php', 'content');
	setTimeout(make_async('navigation.php', 'nav'), 30);
}
function login_attempt()
{
	var usernameVal = document.getElementById("username").value;
	var passwordVal = document.getElementById("password").value;
	var postData = "username=" + usernameVal + "&password=" + passwordVal;

	make_async('form_login.php', 'loginWrap', 'POST', postData);
	make_async('home.php', 'content');
	setTimeout(make_async('navigation.php', 'nav'), 30);
}
function register_attempt()
{
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var firstName = document.getElementById('firstName').value;
	var lastName = document.getElementById('lastName').value;
	var address = document.getElementById('address').value;
	var postalCode = document.getElementById('postalCode').value;
	var city = document.getElementById('city').value;
	var country = document.getElementById('country').value;
	var company = document.getElementById('company').value;
	var phoneNumber = document.getElementById('phoneNumber').value;
	
	var postData = "username=" + username + "&password=" + password + "&firstName="
						+ firstName + "&lastName=" + lastName + "&address=" + address 
						+ "&postalCode=" + postalCode + "&city=" + city + "&country=" 
						+ country + "&company=" + company  + "&phoneNumber=" + phoneNumber;
	make_async('form_register.php', 'content', 'POST', postData);
	setTimeout(make_async('form_login.php', 'loginWrap'));
}
function logout()
{
	make_async('logout.php', 'loginWrap');
	make_async('home.php', 'content');
	setTimeout(make_async('navigation.php', 'nav'), 30);
}
function order_fill_div(divId)
{
	var sel = document.getElementById('selMenu');
	var data = sel.options[sel.selectedIndex].text;
	data = data + "&cost=" + parseInt(sel.options[sel.selectedIndex].title);
	var url = "order.php?article=" + data;

	make_async(url, divId);
}
function load_content_done(req, url, targ)
{
	if (req.readyState == 4 && req.status == 200)
	{ 
		document.getElementById(targ).innerHTML = req.responseText;
	}
}
function load_content(url, target, meth, postData)
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
		if (meth == "POST")
		{
			req.open("POST", url, true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			req.setRequestHeader("Content-length", postData.length);
			req.setRequestHeader("Connection", "close");
			req.send(postData);
		}
		else
		{
			req.open("GET", url, true);
			req.send();
		}
	}
}
function make_async(name, div, method, posted)
{
		load_content(name, div, method, posted);
}

/*
*	Functions to perform order-form related tasks
*/
var cartMax = 200;
//global var to hold all Changed objects
var Changed = new Array;
function Cart()
{
	this.Articles = new Array();
}

//function to add a changed object to our global array above, if its a valid change
function add_changed(ele)
{
	/* insert some validation as a condition to continue */
	if (ele.value !== undefined)
	{
		Changed.push(new Changed_Obj(ele));
	}
}

//object which defines the elements id and some methods to work with it.
//should first check if this element is being re-changed
function Changed_Obj(element)
{
	this.chg = element.id;
	this.quant = element.value;
	this.itemArr = this.chg.split("_");
	this.articleType = this.itemArr[0];
	this.articleCost = this.itemArr[1];
	this.itemName = this.itemArr[2];
	this.color = this.itemArr[4];
	this.size = this.itemArr[5];
}

function order_submission() //very very wrong. Needs to parse json cookie data into the Cart object, add new additions, the parse back to JSON and rewrite the cookie
{
	var numOfChanged = Changed.length;
	var finalPost = "num=" + numOfChanged + "&";
	if (numOfChanged !== 0)
	{
		finalPost = finalPost + Changed[0].articleType;
		for(var i=0; i<numOfChanged; i++)
		{
			finalPost = finalPost + i + "=" + Changed[i].postStr + "&";
		}
		finalPost = finalPost.substring(0, finalPost.length-1);
		add_to_cart(finalPost);
	}
}
function add_to_cart(a, b, c, d, e, f, h)
{
	var existingIndex = check_exists(a, b, c, d, e, f, h);
	if (existingIndex !== null) //if item already exsists in cart
	{
		Cart.Articles[existingIndex].quantity += h;
	}
	else
	{
		newIndex = Cart.Articles.length;
		Cart.Articles[newIndex] = {"articleType":a, "itemName":c, "color":d, "size":f, "quantity": h} //add new json object to Articles
	}
	document.write(newIndex);
	document.write(Cart.Articles[newIndex].size);
}
function check_exists(a2, b2, c2, d2, e2, f2, h2)
{
	if ( Cart.Articles.length==0 )
	{
		return null;
	}
	for (var i=0; i<Cart.Articles.length; i++)
	{
		if (Cart.Articles[i].articleType == a2)
		{
			if (Cart.Articles[i].itemName == c2)
			{
				if (Cart.Articles[i].color == d2)
				{
					if (Cart.Articles[i].size == f2)
					{
						return i;
					}
				}
			}
		}	
	}
	return null;
}

function empty_cart()
{
	while (i<cartMax)
	{
		eraseCookie(i);
		i++;
	}
}
function display_cart()
{

}
function updateCookie(name,value)
{
		eraseCookie(name);
		createCookie(name, value, 1);
}
function createCookie(name,value,hours)
{
	if (hours)
	{
		var date = new Date();
		date.setTime(date.getTime()+(hours*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"=" + value + expires +"; path=/";
}

function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name)
{
	createCookie(name,"",-1);
}