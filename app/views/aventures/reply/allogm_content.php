<?php
session_start();
include("../_shared_/connectDB.php");

$avID = $_POST['avID'];
$userID = $_POST['userID'];
$otherID = $_POST['otherID'];

$req = $bdd->query("
	SELECT *
	FROM mas_allogm
	WHERE avID = '$avID'
	AND fromID IN('$userID', '$otherID')
	AND toID IN('$userID', '$otherID')
	");
$allo = $req->fetchall();

foreach ($allo as $alloMsg) {

	$date = explode('--', $alloMsg['dat']);

	//if from user
	if ($alloMsg['fromID'] == $userID) { ?>
		<div class="alloGM-msg msg-user" id="<?=$alloMsg['id']?>" data-toggle="tooltip" data-placement="left" title="le <?=$date[0]?> à <?=$date[1]?>">
			<?=$alloMsg['content']?>
		</div>
	<?php
	}
	//if to user
	if ($alloMsg['toID'] == $userID) { ?>
		<div class="alloGM-msg msg-other" id="<?=$alloMsg['id']?>" data-toggle="tooltip" data-placement="right" title="le <?=$date[0]?> à <?=$date[1]?>"><?=$alloMsg['content']?></div>		
	<?php
	}
} ?>

<div id="alloGM-userID" userID="<?=$userID?>" hidden></div>
<div id="alloGM-otherID" otherID="<?=$otherID?>" hidden></div>

	<?php
	//SET MSG TO SEEN
	$bdd->query("
		UPDATE mas_allogm
		SET seen = '1' 
		WHERE avID = '$avID'
		AND fromID = '$otherID'
		AND toID = '$userID'
		");
	?>

<script type="text/javascript">
	
	$('.alloGM-content').scrollTop(9999);

/*REFRESH*/

	var alloRefreshInterval = setInterval(function(){

		var lastMsgID = $(".alloGM-msg:not(.temp)").last().attr('id');
	    var userID = $('#alloGM-userID').attr('userID');
	    var otherID = $('#alloGM-otherID').attr('otherID');
	    var avID = $('#avID').html();

		var http = new XMLHttpRequest;
	    http.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
            	/*if new message*/
            	if (http.responseText.length > 0){
            		$(".alloGM-msg.temp").remove();
	            	$('.alloGM-content').append(http.responseText);
					$(".alloGM-content").scrollTop(9999);
				}
	       }
	    };

	    var refine = "?action=alloRefresh"+"&lastMsgID="+lastMsgID+"&userID="+userID+"&otherID="+otherID+"&avID="+avID;

		http.open('GET','server/request_aventures.php'+refine, true);
		http.send();


	}, 5000)

</script>