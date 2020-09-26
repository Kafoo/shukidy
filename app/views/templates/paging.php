<?php

$paging = $variables;

$url = strtok($_SERVER["REQUEST_URI"], '?');

$pageVoidLow = False;
$pageVoidHigh = False;

?>

<div class ="pagination"> Pages :

	<?php
	for ($i=1; $i <= $paging['pageCount'] ; $i++) {



		if ($i <= 3 
			OR ($i >= $paging['page']-1 AND $i <= $paging['page']+1) 
			OR $i >= $paging['pageCount'] -2
			OR ($i == 4 AND $paging['page'] == 6)
			OR ($i == $paging['pageCount']-3 AND $paging['page'] == $paging['pageCount']-5)
			OR ($i == 4 AND $paging['pageCount'] == 7)
		) {

			if ($i==$paging['page']) {
				echo "<span style='color:#c8c8c8'>".$i."</span>";
			}
			else{
				$file = explode('?p', $_SERVER['REQUEST_URI'])[0];
				echo "<a href='".$file."?p=".$i."'>".$i."</a> ";
			}
			if ($i<$paging['pageCount']) {
				echo " - ";
			}

		}else{

			if ($i < $paging['page'] AND $pageVoidHigh == False) {
				echo "... - ";
				$pageVoidHigh = True;
			}
			if ($i > $paging['page'] AND $pageVoidLow == False) {
				echo "... - ";
				$pageVoidLow = True;
			}
		}
	}

	?>
</div>