<?php 

class URLParser
{
	public $htmlstring;
	public $htmldom;
	public $url;
	
	private $metafields;
	
	public function __construct () {
		$this->htmldom = new DOMDocument();
	}
  
	#region Load Functions
		public function LoadUrl($url)
		{
			if(trim($url) != "")
			{
				$this->url = $url;
				$this->LoadHtml(file_get_contents($url));
			}
		}
		
		public function LoadHtml($rawhtml)
		{
			if(trim($rawhtml) != "")
			{
				$this->htmldom = new DOMDocument();
				$this->htmldom->loadHTML($rawhtml);
				$this->htmlstring = $rawhtml;
			}
		}
	#endregion
	
	#region Element Get Fuctions
		function GetTitle() 
		{
			if ($this->htmldom->getElementsByTagName('title')->length != 0) 
				return trim($this->htmldom->getElementsByTagName('title')->item(0)->nodeValue); 		//$res = preg_match("/<title>(.*)<\/title>/siU", $this->htmlstring, $title_matches);
			
			if ($this->htmldom->getElementsByTagName('h1')->length != 0)
				return trim($this->htmldom->getElementsByTagName('h1')->item(0)->nodeValue);
			
			$metas = $this->GetMetaFields();
			foreach ($metas as $name => $value) {
				switch($name) { 
					case "og:title" : return $value; break;
					case "twitter:title" : return $value; break;
					default: return ""; break;
				}
			}
		}

		function GetDescription()
		{
			$metas = $this->GetMetaFields();
			foreach ($metas as $name => $value) {
				switch($name) { 
					case "description" : return $value; break;
					case "og:description" : return $value; break;
					case "twitter:description" : return $value; break;
				}
			}
			
			$paragraphs = $this->htmldom->getElementsByTagName('p');
			if($paragraphs->length != 0) return $this->htmldom->getElementsByTagName('p')->item(0)->nodeValue;
			else return "";
		}
		
		function GetImage()
		{
			$metas = $this->GetMetaFields();
			foreach ($metas as $name => $value) {
				switch($name) { 
					case "og:image" : return $value; break;
					case "twitter:image" : return $value; break;
					default: return ""; break;
				}
			}	
		}
		
		function GetImages()
		{
			$images = array();
			$imagesdom = $this->htmldom->getElementsByTagName('img');
			if($imagesdom->length != 0)
			{
				$count = 0;
				for ($i = 0; $i < $imagesdom->length; $i++)
				{
					$img = $imagesdom->item($i);
					if($img->getAttribute('src') != null)
					{
						$images[$count]["src"] = $img->getAttribute('src');
						if($img->getAttribute('alt') != null) $images[$count]["alt"] = $img->getAttribute('alt');
						if($img->getAttribute('title') != null) $images[$count]["title"] = $img->getAttribute('title');
						$count++;
					}
				}
			}
			return $images;
		}
		
		function GetFeaturedImage()
		{
			$base = trim($this->GetDomainName(true), "/");
			$metas = $this->GetMetaFields();
			foreach ($metas as $name => $value) {
				switch($name) { 
					case "og:image" : return $base.$value; break;
					case "twitter:image" : return $base.$value; break;
				}
			}	
			
			$images = $this->GetImages(); 
			if(count($images) != 0) return $base.$images[0]["src"];
			else return "";
		}
		
		function GetKeywords()
		{
			$metas = $this->GetMetaFields();
			foreach ($metas as $name => $value) {
				switch($name) { 
					case "keywords" : return $value; break;
					case "article:tag" : return $value; break;
					default: return ""; break;
				}
			}	
		}
		
		function GetAuthor()
		{
			$metas = $this->GetMetaFields();
			foreach ($metas as $name => $value) {
				switch($name) { 
					case "author" : return $value; break;
					default: return ""; break;
				}
			}	
		}
		
		function GetMetaFields()
		{
			if($this->metafields != null && count($this->metafields) != 0) return $this->metafields;
			$this->metafields = array();
			
			$fieldnodes = $this->htmldom->getElementsByTagName('meta');
			if($fieldnodes->length != 0)
			{
				for ($i = 0; $i < $fieldnodes->length; $i++)
				{
					$meta = $fieldnodes->item($i);
					if($meta->getAttribute('content') != null)
					{
						if($meta->getAttribute('name') != null) 
							$metafields[$meta->getAttribute('name')] = $meta->getAttribute('content');
						if($meta->getAttribute('property') != null) 
							$metafields[$meta->getAttribute('property')] = $meta->getAttribute('content');
					}
				}
			}
			
			$this->metafields = $metafields;
			return $metafields;
		}
		
		function GetDomainName($baseurl = false)
		{
			if($this->url != null){
				$parse = parse_url($this->url);
				if($baseurl == false) return $parse['host'];
				else return $parse['scheme'] . "://" . $parse['host'] . "/";
			}
			else
				return "";
		}
		
		function GetUrl()
		{
			if($this->url != null) return $this->url;
			else return "";
		}
	#endregion
}
