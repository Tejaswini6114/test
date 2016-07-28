<style>
a{
	background:#333;
	color:#fff;
	text-decoration:none;
	padding:6px;
	border-radius:3px;
	
}
.current{ color:red; background:yellow; text-decoration:none;
	padding:6px;
	border-radius:3px;}
</style> 

<?PHP
include('dbconn.php');

$perPage=15;

$qr1 = "select * from statelist";
$rs= $conn->query($qr1);

//Calculating the total pages

$totalPages = ceil( ($rs->num_rows)/$perPage );

//get the current pages

if( !isset($_GET['page']) ) { $page = 1; }
else
{
	$page = $_GET['page'];
	
	if( !is_numeric($page))
	{
		echo "No results found"; die();
	}
	else
		$page = floor($page);
}

//set start at here

if($page>1)
{
	$startAt = ($page)-1;
}
else
	$startAt=0;


//fetch the data
$rs->close();

$qr2 ="select city_name, state from statelist order by state asc" ;
$qr2.=" limit $startAt, $perPage";

$rs = $conn->query($qr2);

if($rs->num_rows>0)
{
	
	?>
	<table width=350px border=0 cellpadding=0 cellspacing=0>
	<tr>
	 <th>State</th>
	 <th>City</th>
	</tr>
	<?PHP
while($row = $rs->fetch_object() )
{
	?>
	<tr>
		<td><?PHP echo $row->state; ?></td>
		<td><?PHP echo $row->city_name; ?></td>
	</tr>
	
	<?PHP
}
?>
</table>
<?PHP	
}
$links = '';





// create links for first and previous

if( $page>1)
{
	$links = "<a href=pagination.php> First </a>";
	$prev = $page-1;
	$links.="<a href=pagination.php?page=$prev>Prev</a>";
	
}

for($i=($page-6);$i<(10+$page-6);$i++)
{
	if( $i>0 && $i<$totalPages)
	{
$links .= ($i != $page ) ? "<a href='pagination.php?page=$i'> $i</a> " : "<span class='current'> $page</span>";
		
	}
	
}





if( $page<$totalPages)
{
	$nxt = $page+1;
	$links.= "<a href=pagination.php?page=$nxt> Next </a>";
	
	$links.="<a href=pagination.php?page=$totalPages>Last</a>";
	
}

echo "<hr>".$links;

?>