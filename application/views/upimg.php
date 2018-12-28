<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<script type="text/javascript" src="<?php echo $this->config->item('domain_src'); ?>common/js/seajs/sea.js?v=<?php echo time()?>"></script>

    <form method="post" action="/myimg/try_imgs" enctype="multipart/form-data">
    <input class="infoTableFile2" id="category_pic" name="try" type="file">
    <input type="submit" value="提交">
</form>
</head>
<body>
    <hr>
    图片

</body>
</html>