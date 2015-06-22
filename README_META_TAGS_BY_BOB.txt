$url = "http://www.businessinsider.com/map-of-upward-mobility-in-the-us-2015-6";
// http://php.net/manual/en/function.get-meta-tags.php
$tags = get_meta_tags($url);
echo "<pre>";
print_r($tags);
echo "</pre>";
echo "<hr> meta description = ".$tags['description']."<hr>";