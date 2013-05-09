<?php 
/*
Original Author: Abdullah Arif
Fork Author: Jeffery Schefke
License : GNU General Public License
phproxyimproved.com
*/
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
   echo '404';
}
include 'include/settings.php';
include 'include/syssettings.php';

echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<?php
include 'include/settings.php';
if ($googlea != '') {
$googleacode = <<<HTML
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '$googlea']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
HTML;
echo $googleacode;
}
?>
<head>
<title><?php include 'include/settings.php'; echo $sitetitle; ?></title>
<link rel="stylesheet" type="text/css" href="include/style.css">
<script type="text/javascript">
document.getElementById("optionsjs").style.display = 'block';

function toggle(id) {
   var e = document.getElementById(id);
   if(e.style.display == 'block')
	  e.style.display = 'none';
   else
	  e.style.display = 'block';
}
</script>
</head>
<body onload="document.getElementById('address_box').focus()">
<div id="container">
	<h1 id="title"><?php include 'include/settings.php'; echo $sitetitle; ?></h1>
	<ul class="address_tabs">
		<li id="tab1" class="selected"><a>Browse</a></li>
		<li id="tab2"><a href="http://www.proxyhelp.org/mybb">Support</a></li>
	</ul>
<?php
if ($googlet == '1'){
$googletcode = <<<HTML
<div id="google_translate_element"></div><script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
HTML;
echo $googletcode;
}

echo '</ul>';

//Errors
switch ($data['category']){
    case 'error':
        echo '<div id="error"><p>';

        switch ($data['group']) {
            case 'url':
                echo '<b>URL Error (' . $data['error'] . ')</b>: ';
                switch ($data['type']) {
                    case 'internal':
                        $message = 'Failed to connect to the specified host. '
                                 . 'Possible problems are that the server was not found, the connection timed out, or the connection refused by the host. '
                                 . 'Try connecting again and check if the address is correct.';
                        break;
                    case 'external':
                        switch ($data['error']) {
                            case 1:
                                $message = 'The URL you\'re attempting to access is blacklisted by this server. Please select another URL.';
                                break;
                            case 2:
                                $message = 'The URL you entered is malformed. Please check whether you entered the correct URL or not.';
                                break;
                        }
                        break;
                }
                break;
            case 'resource':
                echo '<b>Resource Error:</b> ';
                switch ($data['type']) {
                    case 'file_size':
                        $message = 'The file your are attempting to download is too large.<br />'
                                 . 'Maxiumum permissible file size is <b>' . number_format($GLOBALS['_config']['max_file_size']/1048576, 2) . ' MB</b><br />'
                                 . 'Requested file size is <b>' . number_format($GLOBALS['_content_length']/1048576, 2) . ' MB</b>';
                        break;
                    case 'hotlinking':
                        $message = 'It appears that you are trying to access a resource through this proxy from a remote Website.<br />'
                                 . 'For security reasons, please use the form below to do so.';
                        break;
                }
                break;
        }

        echo 'An error has occured while trying to browse through the proxy. <br />' . $message . '</p></div>';
        break;
}
?>
<div id="address_bar">
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		<input id="address_prefix" type="text" value="http://" disabled></input><input id="address_box" type="text" name="<?php echo $GLOBALS['_config']['url_var_name'] ?>" value="<?php echo isset($GLOBALS['_url']) ? str_replace(' ','',htmlspecialchars($GLOBALS['_url'])) : '' ?>" onfocus="this.select()" /></label>
		<input id="submit" type="submit" value="Go" />
		<span id="settings"><img src="data:;base64,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" onclick="toggle('options');" /></span>

</div>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		<ul id="form">
			<?php
			//Include stock settings file
			include 'include/settings.php';

			//Insert ADs (1)
			echo '<div id="adsense">'.$ads1.'</div>';

			//Proxy options
			echo '<div id="options">';
			foreach ($GLOBALS['_flags'] as $flag_name => $flag_value) {
				if (!$GLOBALS['_frozen_flags'][$flag_name]) {
					echo '<li class="option"><label><input type="checkbox" name="' . $GLOBALS['_config']['flags_var_name'] . '[' . $flag_name . ']"' . ($flag_value ? ' checked="checked"' : '') . ' />' . $GLOBALS['_labels'][$flag_name][1] . '</label></li>' . "\n";
				}
			}
			echo '</div></ul>';
			if ($homepageimage == "1") {
				echo '<img src="include/image.php" />';
			} else {
				echo $homepage;
			}
			?>
	</form>
	<div id="footer">
		<?php include 'include/settings.php'; echo $sitefooter; ?> &nbsp;  <?php include 'include/current.php'; echo $linkbackshow; ?> <?php echo $GLOBALS['_version'] ?></div>
	</div>
</div>
</body>
</html>
