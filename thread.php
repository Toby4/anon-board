<?php include("inc/header.php"); ?>

<form action="upload.php" method="post" enctype="multipart/form-data">
	<h3>New Thread</h3>

	<label for="file">Filename:</label>
	<input type="file" name="image"><br>
	<textarea cols="40" rows="5" name="comment">Thread Comment</textarea><br />
	<input type="submit" id="submit" name="submit">
</form>

<?php include("inc/footer.php");