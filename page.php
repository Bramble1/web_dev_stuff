<!DOCTYPE html>
<html>

<head>

<script>
function myFunction()
{
	item = document.getElementById('item').value;
	days = document.getElementById('days').value;
	amount = document.getElementById('amount').value;

	amount = amount / days;
//	alert(item + " with " + amount + " will last " + days);
	document.getElementById("result").innerHTML="amount per day(grams)= " + amount;	

}
</script>

<?php

include("table_management.php");

//servername="localhost"
//username="username"
//password="password"
//dbname="Items"
//Table="rationed_items"

$ration = new table_manager("localhost","username","password","Items","rationed_items");

//Put the functions into a class,in a seperate php file and include it and create
//an object instance to make the code look cleaner etc.


	$test=[];

if(isset($_POST['submitb']))
{
	$message="SERVER RECIEVED INFORMATION.";

	/*create and add to database*/
	/*then show database so far with html table surrounding in like
	 * in prior tutoraisl from w3school,simple simple first webapp.*/

	/*then have javascript to be able to print the page, once the user
	has finished with the list. simple one page webapp.Keep it simple*/
	/*this simple example just add it to a list and display it
	as well as allowing the user to send a delete item request*/
	
	/*button to save on the system as a file,so php will send it as json or
	 * something*/

	$entries = $_POST;

	$test = array($_POST['item'],$_POST['amount'],$_POST['days']);
	//$test[]=$_POST['item'];
	//array_push($test,$_POST['item']);
	

	//need persistent, so a store list function/add to list function and print list, store in memory somewhere.
	//apparently php has no concept of persistence, so it's recommendded to use a database.	
	

//	$entries = array("entry1","entry2","entry3");
	//	$msg = $_POST['days'];
	//

	//	create_database();
	
/*	$servername="localhost";
	$username="username";
	$password="pasword";
	$dbname="Items";
 */


	$db = db_connect();
	create_database($db);
	add_table($db);

//	open_database();	
//	create_table();
	insert_data($test);
	view_data();

//	$conn=null;
}

if(isset($_POST['deleteb']))
{
	/*check if input is a number for this function*/
	$test = array($_POST['item']);
	delete_data($test);
	view_data();	
}

if(isset($_POST['delete_tableb']))
{
	delete_table();
	ration.delete_database();
}


function db_connect()
{
	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	$db="mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
	$options= array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

	return new PDO($db,$username,$password,$options);
}

function create_database($conn)
{
	$dbname="Items";
	$sql="create database if not exists " . $dbname;


	try
	{
		$conn->exec($sql);
		echo "database created(if not already)<br>";
	}catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
}

function open_database()
{
	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	try
	{
		$conn = new PDO("mysql:host=$servername",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			
		$sql="create database if not exists " . $dbname;
		$conn->exec($sql);

		echo "database created successfully<br>";	
	} catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
	$conn=null;
}

function add_table($conn)
{
	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	try
	{
		$sql="create table if not exists rationed_items(
		id INT AUTO_INCREMENT PRIMARY KEY,
		name	VARCHAR(30) NOT NULL,
		serving INT(6),
		days INT(6),
		UNIQUE KEY unique_name (name)
		);";
	
		$conn->exec($sql);
		echo "Table rationed_items created(if not already)<br>";
	}catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
}

function create_table()
{
	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	try
	{
		//$con=$connection;
		$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		//$sql="create table if not exists rationed_items(id INT(6) UNSIGNED AUTO_INCREMENT
		//	PRIMARY KEY,name VARCHAR(30) NOT NULL,serving INT(6),
		//	days INT(6))";

		$sql="create table if not exists rationed_items(
			id INT AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30) NOT NULL,
			serving INT(6),
			days INT(6),
			UNIQUE KEY unique_name (name)
		);";

		$conn->exec($sql);
		echo "Table rationed_items created successfully";
	}catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();	
	}
	$conn=null;
}

function delete_table()
{
	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	try
	{
		$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql="drop table if exists rationed_items;";
		$conn->exec($sql);
		echo "table deleted";
	}catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
	$conn=null;
}

function insert_data($test)
{
	/*check if record exists,if exists, just update the record
	otherwhise sql will ignore it and just add the entry,so need
	to work out syntax for sql and look at update_data.php for
	reference. Check if name already exists,and if so, then update
else insert,see if we can use If statements in sql statements*/

	

	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	$sql;

	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//$sql="insert into rationed_items(name,serving,days) values ('$test[0]','24','5')";

		$sql="insert into rationed_items(name,serving,days) values ('$test[0]','$test[1]','$test[2]')
			on duplicate key update serving='$test[1]',days='$test[2]'"; 

	       	$conn->exec($sql);
		$last_id = $conn->lastInsertId();
		echo "New record created.Inserted ID=" . $last_id;	
	}catch(PDOEXCEPTION $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
	$conn = null;
}

function delete_data($test)
{
	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";
	try
	{
		$conn=new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

		$sql = "delete from rationed_items where id=$test[0]";
		$conn->exec($sql);
		echo "Record deleted successfully";
	}catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
$conn=null;	
	
}

function view_data()
{

	echo "<table style='border: solid 1px black;'>";
	echo "<tr><th>Id</th><th>name</th><th>serving</th><th>days</th></tr>";
	
	class TableRows extends RecursiveIteratorIterator
	{
		function __construct($it)
		{
			parent::__construct($it,self::LEAVES_ONLY);
		}
		
		function current()
		{
			return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
		}

		function beginChildren()
		{
			echo "<tr>";
		}

		function endChildren()
		{
			echo "</tr>" . "\n";
		}
	}

	$servername="localhost";
	$username="username";
	$password="password";
	$dbname="Items";

	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);

		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare("select id,name,serving,days from rationed_items");
		$stmt->execute();

		$result=$stmt->setFetchMode(PDO::FETCH_ASSOC);

		foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v)
		{
			echo $v;
		}
	} catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
	echo "</table>";
}

?>



</head>


<body>

<!--deliberate action is blank, as we want to remain on the same page-->
<form action="" method="post">
<label>Food Item</label>
<input type="text" id="item" name="item"><br><br>
<label for amount>Grams</label>
<input type="text" id="amount" name="amount"><br><br>
<label for days>Days</label>
<input type="text" id="days" name="days"><br><br>
<button type="button" onclick="myFunction()">calculate</button>
<input type="submit" value="Add/Update" name="submitb"/>
<input type="submit" value="delete" name="deleteb"/>
<input type="submit" value="delete table" name="delete_tableb"/>
</form>

<p id="result"></p>

<?php echo $message; ?>


<?php

//1.get set number elements.
//2.foreach < number, echo "<table element>entry[i]<"table">
//not working,maybe because it's not a global var,so we could have a class instance
//if that the case,but message works fine
echo "<table style='border:solid 1px black;'>";
foreach($test as $value)
{
	echo "<tr><th>$value</th></tr>";
	
}
echo "<p>$msg</p>";
/*for($i=0;$i<3;$i++)
{
	echo "<tr><th>$msg</th></tr>";
	echo "<p>$msg</p><br><br>";
}*/

//echo "<table style='border:solid 1px black;'>";
//echo "<tr><th>$msg</th><tr>";
//echo "<tr><th>Id</th><th>Item</th><th>average</th><th>days</th></tr>";
echo "</table>";
?>

</body>
</html>

