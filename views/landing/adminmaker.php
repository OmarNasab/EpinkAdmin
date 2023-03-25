<?php
if(isset($_GET["table"])){
	$table = cleanInput($_GET["table"]);
	$result = $db->query("describe ".$dbname.".".$table."");
	if ($result->num_rows > 0) {
		$array = '';
		while ($row = $result->fetch_assoc()) {
			if($row["Field"] != "id"){
				$array .= "'".$row["Field"]."', ";
			}
		}
	}
}
?>

<section class="bg-white py-10">
	<div class="container bg-white">
	<p><strong>Nav</strong></p>
	<input type="text" id="navname" onkeyup="changeNavName(this)" class="form-control">
	<p><strong></strong></p>
	<pre id="navigationcode"></pre>
	<p><strong>Index Code</strong></p>
	<pre id="indexcode"></pre>
	</div>
	<script>
		function changeNavName(element){
			var name = element.value;
			var name = element.value;
			var url = name.replaceAll(' ', '-');
			var url = url.toLowerCase(' ', '-');
			'+name+'
			document.getElementById("navigationcode").innerHTML = '&ltli class="nav-item"&gt<br>';
			document.getElementById("navigationcode").innerHTML += '    &lta href="&lt?php echo $domain;?&gt/'+url+'/" class="nav-link"&gt&ltp&gt'+name+'&lt/p&gt&lt/a&gt';
			document.getElementById("navigationcode").innerHTML += '<br>&lt/li&gt';
			document.getElementById("indexcode").innerHTML  = 'elseif($page_identifier == "'+url+'"){<br>';
			document.getElementById("indexcode").innerHTML  += '    $pagename = \"'+name+'\";';
			document.getElementById("indexcode").innerHTML  += '<br>    if($page_identifier_action == ""){';
			document.getElementById("indexcode").innerHTML  += '<br>        include("controllers/session.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/header.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/navigation.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/'+url+'-list.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/footer.php");';
			document.getElementById("indexcode").innerHTML  += '<br>    }elseif($page_identifier_action == "view"){';
			document.getElementById("indexcode").innerHTML  += '<br>        include("controllers/session.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/header.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/navigation.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/'+url+'-view.php");';
			document.getElementById("indexcode").innerHTML  += '<br>        include("views/footer.php");';
			document.getElementById("indexcode").innerHTML  += '<br>    }';
			document.getElementById("indexcode").innerHTML  += '<br>}';
		}
	</script>
</section>