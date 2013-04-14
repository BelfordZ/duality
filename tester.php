<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
var myObj = new Array;
function doit(elem)
{
	myObj.push(new dewit(elem));
}
function dewit(ele)
{
	this.Changed;
	this.val = ele.value;
	this.fucker = new Array;
	this.submitted=submitted;
	
	if (ele.value !== undefined)
	{
		this.Changed = ele.id;
		this.submitted();
	}
}
function submitted()
{
	this.fucker = this.val.split("_");
}
function getit()
{
	var daSize = myObj.length;
	for (var i=0; i<daSize; i++)
	{
		document.write(encodeURI(myObj[i].fucker));
	}
}

</script>
</head>
<body>

<div id="test">
<form>
<input id="meatHammer" type="text" value="" onchange="doit(this)">
<br/>
<input id="meatHammer2" type="text" value="" onchange="doit(this)">
<br/>
<input id="submission" type="button" value="submit" onclick="getit()"/>
</form>
</div>

</body>
</html>