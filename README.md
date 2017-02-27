# PHP Web Page HTML Parser
Simple PHP class to parse a webpage with functions to extract the content of the page for us with a website preview tool.

<h2>Parsing Webpage With PHP</h2>
Here is a simple example on how you would use the class to obtain data about a page.

```php
require_once "Parser.php";

$parser = new URLParser();
$parser->LoadUrl("https://website.com/somepost");

$title = $parser->GetTitle();
$description =  $parser->GetDescription();
$image $parser->GetFeaturedImage();
```

All available methods can be found within the Parser.php class.

A good expanded use for this class would be to create a link preview using jQuery and AJAX. Create a php script to accept a URL and return the preview html. Using jQuery, perform an AJAX request and send the URL. The script will then return HTML preview of the url. The following HTML can be used to obtain and display a simple preview of a url. See GetPreview.php for a better idea on how to use the script.

```html
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
  ```
