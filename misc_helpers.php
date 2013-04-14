<?php
function int_to_char($the_int)
{
	$the_int+=48;
	if ($the_int < 58)
	{
		return chr($the_int);
	}
	$tens = 0;
	while ($the_int > 57)
	{
		$tens++;
		$the_int-=10;
	}
	if ($tens > 9)
	{
		return (int_to_char($tens) . chr($the_int));
	}
	return (chr($tens+48) . chr($the_int));
}
?>
