<?php
	include_once 'header.php';
?>
        <article>
		<?php
			//if the user logged in
			if(isset($_SESSION["useruid"])){
				echo "Hello there " . $_SESSION["useruid"];
			}else{
				echo "Please Login";
			}
		?>
		
        </article>
<?php
	include_once 'footer.php';
?>