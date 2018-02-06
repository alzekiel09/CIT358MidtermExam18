<?php
if(ISSET($_POST['submit'])){
	$title = $_POST['book_title'];
	$pages = $_POST['book_pages'];
	$author = $_POST['book_author'];
	$published_year = $_POST['published_year'];
	$conn = new mysqli("localhost", "root", "", "library") or die(mysqli_error());
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$q1 = $conn->query ("SELECT * FROM `books` WHERE `book_title` = '$book_title'") or die(mysqli_error());
	$f1 = $q1->fetch_array();
	$check = $q1->num_rows;
	if($check > 0){
		echo "<script> alert ('Book Already Exist In The Database')</script>";
		echo "<script>document.location='addbook.php'</script>";
	}
	else {
		$conn->query("INSERT INTO `books` VALUES('', '$book_title', '$book_pages', '$book_author', '$published_year')") or die(mysqli_error());
		$conn->close();
		echo "<script type='text/javascript'>alert('Successfully Added New book!');</script>";
		echo "<script>document.location='addbook.php'</script>";  
	}
}
?>
<html>

<head>
	<title>Book Information</title>
    <link href="assets/css/reg.css" rel="stylesheet">
</head>

<body>
	<form action="" method="post">
	<h1>Library Database</h1>
	<fieldset>
		<legend>Book Information</legend>
		<label>Title:</label> <input type="text" name="book_title" required/><br />
		<label>Pages:</label> <input type="number" min=1 name="book_pages" required/><br />
		<label>Author:</label> <input type="text" name="book_author" required/><br />
		<label>Published Year:</label> <input type="text" name="published_year" required/>
        <div><br/></div>
    <input style="float:right" type="submit" value="Add Book" name="submit"/>
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
					$query = $conn->query("SELECT * FROM `library` ORDER BY `book_id` DESC") or die(mysqli_error());
					while($fetch = $query->fetch_array()){
					?>
					<tr>
						<td><center><?php echo $fetch['book_title']?></center></td>
						<td><center><?php echo $fetch['book_pages']?></center></td>
						<td><center><?php echo $fetch['book_author']?></center></td>
						<td><center><?php echo $fetch['published_year']?></center></td>
						<td><center>
							<button>Delete</button>
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
</body>
</html>