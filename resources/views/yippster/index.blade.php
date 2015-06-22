<html>
<head>
<title>Magazine Store| Demo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="viewport" content="width=device-width" />
	<link type="text/css" rel="stylesheet" media="all" href="mobile.css" />
	<link href="galleryStyle-index.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="/favicon.ico">

</head>
<body leftmargin="0" marginheight="0" marginwidth="0" topmargin="0" bgcolor="#FFFFFF"  >
<br>

<div align="center" class="mainCenter">
	<table style="width:100%; height:20%"; border="0"; bgcolor="#FFFFFF">
		<tr height="20%">
		<td colspan="3" style="border-style:none none solid;">
				<a class="main" href="index.php"><img src="logo.png"></img><h1>Magazine Store</h1></a></td>
		</tr>
	</table>

<table style="width:100%;"; border="0"; bgcolor="#FFFFFF">
		<tr><td  colspan="3" class="c"><br><img src="images/india-today.jpg"></td>
			</tr>
		<tr>
			<td style="width:10%"></td>
			<td class="c1"><h>India Today Rs.{{ Session::get("amount") }} </h><a href="{{ route('yippster.ext') }}"><img src="http://yippster.com/smspay/button.php?amt={{  Session::get('amount') }}"></a><br><br>
				</td>
			<td style="width:10%"></td>
		</tr>
	</table>';
</div>
</body>
</html>