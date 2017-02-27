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

A good expanded use for this class would be to create a link preview using jQuery and AJAX. Create a php script to accept a URL and return the preview html. Using jQuery, perform an AJAX request and send the URL. The script will then return HTML preview of the url.
