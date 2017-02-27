<?php
if(isset($_POST['url']))
{
	require_once "Parser.php";
	$parser = new URLParser();
	$parser->LoadUrl($_POST['url']);
	echo "<h1>" . $parser->GetTitle() . "</h1>";
	if($parser->GetFeaturedImage() != "") echo "<img src='" . $parser->GetFeaturedImage() . "'/>";
	echo "<p>" . $parser->GetDescription() . "</p>";
}
else 
{
?>
	<style>
		#url{width:80%; margin-left:10%; margin-right:10%; padding:5px;}
		#previewcontent{margin-top:50p; width:80%; margin-right:10%; margin-left:10%;}
	</style>
	<h1>HTML Page Preview Generator</h1>
	<p>Enter a url in the box below and press the enter key. This will generate a page preview below</p>
	<input type="text" id="url" name="url" placeholder="Enter URL and press enter">
	<div id="previewcontent">
	
	</div>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script>
	$( document ).ready(function() {
		$('#url').keyup(function(e){
			if(e.keyCode == 13) GetURLPreview();			
		});
	});
		function GetURLPreview()
		{
            $.ajax({
				url: 'GetPreview.php',
				global: false,
				type: 'POST',
				data: { url : $("#url").val()},
				success: function(html) {
					$("#previewcontent").html(html);
				}
			});
		}
	</script>
<?php 
}
?>
