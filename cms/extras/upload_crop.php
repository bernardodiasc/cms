<?php
/*
* Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* "PHP & Jquery image upload & crop"
* Date: 2008-11-21
* Ver 1.2
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
*/

// Set flag that this is a parent file
define( '_CMS', 1 );

error_reporting (E_ALL ^ E_NOTICE);

require_once("init.php");

//only assign a new timestamp if the session variable is empty
/*
if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key'])==0){
    $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
	$_SESSION['user_file_ext']= "";
}
echo "$_SESSION[random_key] : ".$_SESSION['random_key'];
echo "<br>";
echo "$_SESSION[user_file_ext] : ".$_SESSION['user_file_ext'];
*/
if (!is_logged() || !isset($_GET['upload_key']) || strlen($_GET['upload_key'])==0) die("");

$upload_key = injection($_GET['upload_key']);

$registro = mysql_query("SELECT * FROM upload_temp WHERE upload_key = '".$upload_key."'");
if (mysql_num_rows($registro) < 1) {
	$upload_dir = "upload_pic"; 
	$unique_key = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
	mysql_query("INSERT INTO upload_temp (id,file_ext,upload_dir,unique_key,upload_key,horario) VALUES ('', '', '".$upload_dir."', '".$unique_key."', '".$upload_key."', NOW())") or die(mysql_error());
	$file_ext = "";
} else {
	$upload_dir = mysql_result($registro,0,'upload_dir');
	$unique_key = mysql_result($registro,0,'unique_key');
	$file_ext	= mysql_result($registro,0,'file_ext');
}

//echo "\$upload_dir: ".$upload_dir." - \$unique_key: ".$unique_key." - \$file_ext: ".$file_ext;

#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################
//$upload_dir = "upload_pic"; 				// The directory for the images to be saved in
$upload_path = $upload_dir."/";				// The path to where the image will be saved
$original_image_sufix = "_original"; 		// The sufix name to original image
$resized_image_sufix = "_resized"; 			// The sufix name to resized image
$thumb_image_sufix = "_thumbnail";			// The sufix name to the thumb image
$original_image_name = $unique_key.$original_image_sufix;		// New name of the original image (append the timestamp to the filename)
$resized_image_name = $unique_key.$resized_image_sufix;     	// New name of the resized image (append the timestamp to the filename)
$thumb_image_name = $unique_key.$thumb_image_sufix;     		// New name of the thumbnail image (append the timestamp to the filename)
$max_file = "3"; 							// Maximum file size in MB
$max_width = "500";							// Max width allowed for the resized image
$max_height = "600";						// Max height allowed for the resized image
$thumb_width = "100";						// Width of thumbnail image
$thumb_height = "100";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // do not change this
$image_ext = "";	// initialise variable, do not change this.
foreach ($allowed_image_ext as $mime_type => $ext) {
    $image_ext.= strtoupper($ext)." ";
}


##########################################################################################################
# IMAGE FUNCTIONS																						 #
# You do not need to alter these functions																 #
##########################################################################################################
function resizeImage($image_resize,$image,$width,$height,$scale) {
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$image_resize); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$image_resize,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$image_resize);  
			break;
    }
	
	chmod($image_resize, 0777);
	return $image_resize;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break;
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}

//Image Locations
$original_image_location = $upload_path.$original_image_name;
$resized_image_location = $upload_path.$resized_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;

//Create the upload directory with the right permissions if it doesn't exist
if(!is_dir($upload_dir)){
	mkdir($upload_dir, 0777);
	chmod($upload_dir, 0777);
}

//Check to see if any images with the same name already exist
if (file_exists($resized_image_location.".".$file_ext)){
	if(file_exists($thumb_image_location.".".$file_ext)){
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name.".".$file_ext."\" alt=\"Thumbnail Image\"/>";
	}else{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$resized_image_name.".".$file_ext."\" alt=\"Large Image\"/>";
} else {
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload"])) { 
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$userfile_type = $_FILES['image']['type'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
	
	//Only process if the file is a JPG, PNG or GIF and below the allowed limit
	if((!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0)) {
		
		foreach ($allowed_image_types as $mime_type => $ext) {
			//loop through the specified image types and if they match the extension then break out
			//everything is ok so go and check file size
			if($file_ext==$ext && $userfile_type==$mime_type){
				$error = "";
				break;
			}else{
				$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
			}
		}
		//check if the file size is above the allowed limit
		if ($userfile_size > ($max_file*1048576)) {
			$error.= "Images must be under ".$max_file."MB in size";
		}
		
	}else{
		$error= "Select an image for upload";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0){
		
		if (isset($_FILES['image']['name'])){
			//this file could now has an unknown file extension (we hope it's one of the ones set above!)
			$original_image_location = $original_image_location.".".$file_ext;
			$resized_image_location = $resized_image_location.".".$file_ext;
			$thumb_image_location = $thumb_image_location.".".$file_ext;
			
			//put the file ext in the session so we know what file to look for once its uploaded
			//$_SESSION['user_file_ext']=".".$file_ext;
			
			move_uploaded_file($userfile_tmp, $original_image_location);
			chmod($original_image_location, 0777);
			
			$width = getWidth($original_image_location);
			$height = getHeight($original_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width && ($width-$max_width > $height-$max_height)){
				$scale = $max_width/$width;
				$uploaded = resizeImage($resized_image_location,$original_image_location,$width,$height,$scale);
			}elseif ($height > $max_height && ($width-$max_width < $height-$max_height)){
				$scale = $max_height/$height;
				$uploaded = resizeImage($resized_image_location,$original_image_location,$width,$height,$scale);
			}else{
				$scale = 1;
				$uploaded = resizeImage($resized_image_location,$original_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location)) {
				unlink($thumb_image_location);
			}
			
			mysql_query("UPDATE upload_temp SET file_ext = '".$file_ext."', upload_dir = '".$upload_dir."', horario = NOW() WHERE upload_key = '".$upload_key."'");
		}
		//Refresh the page to show the new uploaded image
		header("location:".$_SERVER["PHP_SELF"]."?upload_key=".$upload_key);
		exit();
	}
}

if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0) {
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location.".".$file_ext,$resized_image_location.".".$file_ext,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail
	header("location:".$_SERVER["PHP_SELF"]."?upload_key=".$upload_key);
	exit();
}


if ($_GET['a']=="delete" && strlen($_GET['t'])>0){
//get the file locations 
	$resized_image_location = $upload_path.$resized_image_sufix.$_GET['t'];
	$thumb_image_location = $upload_path.$thumb_image_sufix.$_GET['t'];
	if (file_exists($resized_image_location)) {
		unlink($resized_image_location);
	}
	if (file_exists($thumb_image_location)) {
		unlink($thumb_image_location);
	}
	header("location:".$_SERVER["PHP_SELF"]);
	exit(); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="generator" content="WebMotionUK" />
	<title>Upload de Imagem</title>
	<script type="text/javascript" src="js/jquery-pack.js"></script>
	<script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
</head>
<body onload="<?php if ($thumb_photo_exists != "") { ?>window.opener.atualizaImagem('<?php echo $upload_key; ?>','<?php echo $upload_path.$thumb_image_name.".".$file_ext; ?>');<?php } ?>">
<!-- 
* Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* Date: 2008-11-21
* "PHP & Jquery image upload & crop"
* Ver 1.2
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
-->
<?php
//Only display the javacript if an image has been uploaded
if(strlen($large_photo_exists)>0){
	$current_resized_image_width = getWidth($resized_image_location.".".$file_ext);
	$current_resized_image_height = getHeight($resized_image_location.".".$file_ext);?>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 
	
	$('#thumbnail + div > img').css({ 
		width: Math.round(scaleX * <?php echo $current_resized_image_width;?>) + 'px', 
		height: Math.round(scaleY * <?php echo $current_resized_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
}); 

$(window).load(function () { 
	$('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
});
<?php
if ($thumb_photo_exists != "") {
?>
function send(){
	window.opener.atualizaImagem('<?php echo $upload_key; ?>','<?php echo $upload_path.$thumb_image_name.".".$file_ext; ?>');
	//window.opener.execScript('atualizaImagem(\'<?php echo $upload_key; ?>\',\'<?php echo $thumb_photo_exist; ?>\')')
	self.close();
}
<?php
}
?>
</script>
<?php }?>
<h3>Photo Upload and Crop</h3>
<?php
//Display error message if there are any
if(strlen($error)>0){
	echo "<ul><li><strong>Error!</strong></li><li>".$error."</li></ul>";
}
if(strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0){
	echo $large_photo_exists."&nbsp;".$thumb_photo_exists;
	//echo "<p><a href=\"".$_SERVER["PHP_SELF"]."?a=delete&t=".$_SESSION['random_key'].$_SESSION['user_file_ext']."\">Delete images</a></p>";
	//echo "<p><a href=\"".$_SERVER["PHP_SELF"]."\">Upload another</a></p>";
	echo "<a onclick=\"send()\" style=\"cursor:pointer;\">FECHAR</a>";
}else{
		if(strlen($large_photo_exists)>0){?>
		<h4>Create Thumbnail</h4>
		<div align="center">
			<img src="<?php echo $upload_path.$resized_image_name.".".$file_ext;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
			<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
				<img src="<?php echo $upload_path.$resized_image_name.".".$file_ext;?>" style="position: relative;" alt="Thumbnail Preview" />
			</div>
			<br style="clear:both;"/>
			<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>?upload_key=<?php echo $upload_key; ?>" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>
	<hr />
	<?php 	} ?>
	<h4>Upload Photo</h4>
	<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>?upload_key=<?php echo $upload_key; ?>" method="post">
	Photo <input type="file" name="image" size="30" /> <input type="submit" name="upload" value="Upload" />
	</form>
<?php } ?>
<!-- Copyright (c) 2008 http://www.webmotionuk.com -->
</body>
</html>
