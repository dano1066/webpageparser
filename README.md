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
