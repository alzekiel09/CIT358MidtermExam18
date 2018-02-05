<?php
//add record
if(ISSET($_POST['submit'])){
	$firstname = $_POST['title'];
	$lastname = $_POST['pages'];
	$gender = $_POST['author'];
	$year = $_POST['year'];


	$conn = new mysqli("localhost", "root", "", "library") or die(mysqli_error());
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$q1 = $conn->query ("SELECT * FROM `registration` WHERE `title` = '$title' ") or die(mysqli_error());
	$f1 = $q1->fetch_array();
	$check = $q1->num_rows;
	if($check > 0){
		echo "<script> alert ('Title Book Already exist!')</script>";
		echo "<script>document.location='addbook.php'</script>";
	}
	else {
		$conn->query("INSERT INTO `registration` VALUES('', '$title', '$pages', '$gender', '$age', '$year')") or die(mysqli_error());
		$conn->close();
		echo "<script type='text/javascript'>alert('Successfully added new record!');</script>";
		echo "<script>document.location='index.php'</script>";  
	}
}
// edit record
if(ISSET($_POST['editrecord'])){
	$book_id = $_POST['book_id'];
	$title = $_POST['title'];    
	$pages = $_POST['pages'];
	$author = $_POST['author'];
	$year = $_POST['year'];

	$conn = new mysqli("localhost", "root", "", "library") or die(mysqli_error());
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$conn->query("UPDATE `registration` SET `title` = '$title', `pages` = '$pages', `author` = '$author', `year` = '$year'
		 WHERE `book_id` = '$book_id'") or die(mysqli_error());
	$conn->close();
	echo "<script type='text/javascript'>alert('Successfully updated record!');</script>";
	echo "<script>document.location='index.php'</script>";  
}
?>
<html>

<head>
	<title>Book Information</title>
    <link href="assets/css/reg.css" rel="stylesheet">
</head>

<body>
	<form action="registration" method="post">
	<h1>Library Database</h1>
	<fieldset>
		<legend>Book Information</legend>
		<label>Title:</label> <input type="text" name="title" required/><br />
		<label>Pages:</label> <input type="number" min=1 name="pages" required/><br />
		<label>Author:</label> <input type="text" name="author" required/><br />
		<label>Published Year:</label> <input type="text" name="year" required/>
        <div><br/></div>
    <input style="float:right" type="submit" value="Add Book" onClick="return submit_form();" name="submit"/>
    </fieldset>
    <h3>List of Stored Books</h3>
    <table border="2" align="center" cellpadding=5>
            <thead>
                <tr><th>Title</th>
                    <th>Pages</th>
                    <th>Author</th>
                    <th>Published Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
				$conn = new mysqli("localhost", "root", "", "library") or die(mysqli_error());
				$query = $conn->query("SELECT * FROM `registration` ORDER BY `book_id` DESC") or die(mysqli_error());
				while($fetch = $query->fetch_array()){
				?>
				<tr>
					<td><center><?php echo $fetch['book_id']?></center></td>
					<td><center><?php echo $fetch['title']?></center></td>
					<td><center><?php echo $fetch['pages']?></center></td>
					<td><center><?php echo $fetch['author']?></center></td>
					<td><center><?php echo $fetch['year']?></center></td>
					<td><center>
						<button href="#update.php<?php echo $fetch['book_id'];?>" data-target="#updaterecord<?php echo $fetch['book_id'];?>" data-toggle="modal"></button>
						<button onclick = "return confirm('Are you sure you want to delete this record?');" href = "delete.php?book_id=<?php echo $fetch['book_id']?>"></span></button>
						</center>
					</td>
				</tr>
				<?php
				}
				$conn->close();
				?>
            </tbody>
        </table>
	</form>
    <script type="text/javascript" src="assets/js/jquery-1.10.2.js"></script>
	<script type="text/javascript">
		function submit_form(){
			alert("A new book has been successfully added!");
		}
	</script>
<?php $conn->close(); ?>
</body>
</html>