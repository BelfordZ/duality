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
function Changed_Obj(element)
{
	this.chg = element.id;
	this.quant = element.value;
	this.prePostStr = new Array;
	this.postStr = "";
	this.articleType = "";
	this.articleCost = "";
	
	this.make_post_data_str = make_post_data_str;
	this.make_post_data_str();
	this.postStr = "!quantity#" + this.quant + "!" + this.postStr;
}
function make_post_data_str()
{
	this.prePostStr = this.chg.split("_");
	
	this.postStr = "item#" + this.prePostStr[2] + "!sid#" + this.prePostStr[3] + "!color#" + this.prePostStr[4] + "!size#" + this.prePostStr[5];
	this.postStr = encodeURI(this.postStr);
	this.articleType = "article=" + this.prePostStr[0] + "&";
	this.articleType = this.articleType + "cost=" + this.prePostStr[1] + "&";
}
function order_submission()
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
		//check_cart_for_dupes(finalPost);
		add_to_cart(finalPost);
		//make_async("form_order.php","content");
	}
}
function add_to_cart(cartAddition)
{
	//look for initialized cookies
	//  for each init'd
	//      for each item in the init'd
	//          check if duplicate with each of the cart addition's items
	//                 if is duplicate, update init'd cookies item, adding to the quantity, and check the others 
	//
	// consider making a class for a general article-order
	// each article-order class has many subclasses for article-item-order
	//     -parse each cookie into the object
	//     -parse the cartAddition into the object
	// create a worker object that takes both objects, and either updates a cookie for each cartaddition's article-item-order
	//               or if no duplicates are found, creates a new cookie for the article-order
	for (var i=0; i<cartMax; i++)
	{
		var cook = readCookie(i)
		if (cook !== null)
		{
			var item = cook.split("&");
			item.shift();
			item.shift();
			item.shift();
			var numOfItems = item.length;
			var itemData = new Array;
			var changedData = new Array;		
			var itemNum = new Array;
			
			for (var j=0; j<numOfItems; j++)
			{
				itemData[j] = item[j].split("!");
				itemNum[j] = itemData[j].shift();
				
				for (var k=0; k<itemData[j].length; k++)
				{
					itemData[j][k] = itemData[j][k].split("#");
					itemData[j][k].shift();
					itemData[j][k] = decodeURI(itemData[j][k]);
				}
				for (var p=0; p<Changed.length; p++)
				{
					if (itemData[j][1] == Changed[p].prePostStr[2])
					{
						if (itemData[j][2] == Changed[p].prePostStr[3])
						{
							if (itemData[j][4] == Changed[p].prePostStr[5])
							{
								var prevQuant = itemData[j][0];
								var itemNumber = itemNum[j].replace("=", "");
								var addedQuant = parseInt(Changed[p].quant);

								var newQuant = (parseInt(addedQuant)) + (parseInt(prevQuant));						
								
								var oldStr = "&" + itemNumber + "=!quantity#" + prevQuant;
								var oldStr1 = "&" + itemNumber + "=!quantity#";
								var replStr = "&" + itemNumber + "=!quantity#" + newQuant;
								
								var ind = cook.indexOf(oldStr1) + oldStr1.length;
								var ind1 = cook.indexOf(oldStr) + oldStr.length;
								
								var tmpCook = cook.substring(0, ind);
								var tmpCook1 = cook.substring(ind1);								
								var newCook = tmpCook + newQuant + tmpCook1;
								
								cook = newCook;
							}
						}
					}
				}
			}
			updateCookie(i, cook);
			i = cartMax +1;
		}
		else
		{
			createCookie(i, cartAddition, 1);
			i = cartMax +1;
		}
	}
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