<!DOCTYPE html>
<html>

<head>

<script>
function myFunction()
{
	//the functoin is being called, but document methods not working it seems
	alert("function called");

	item = document.getElementById('item').value;
	days = document.getElementById('days').value;
	amount = document.getElementById('amount').value;

	amount = amount / days;
//	alert(item + " with " + amount + " will last " + days);
	document.getElementById("result").innerHTML="amount per day(grams)= " + amount;

	//change grams textfield to contain average, then show button,to add,and then hide button
	//for adding/updating until they have calculated the average
	document.getElementById("amount").value=amount;	
	document.getElementById("add").style.display="inline";
	//document.getElementById("add").style.visibility="hidden";
 /*FUNCTION IS  !*/

	//set a textfield in the php form to contain this calculated amount so the php
	//will recieve the serving size, in input[1], rather than the total size...
}
</script>

<!--Server side -->
<?php

include("objects.php");

//read from file ,so not hardcoded,however will be visible at runtime...
$servername="localhost";
$username="username";
$password="password";
$dbname="Items";
$table="rationed_items";

//create Ration instance and filter instance
$ration = new Ration($username,$password,$servername,$dbname,$table);
$filter = new Filter_info();
//requests, Similiar OR is EVENT DRIVEN PARADIGM.So in our best interest to open and close functions
//even though it results in 2*code_duplication in regards to safely closing and opening connections
//I can't trust the user to click the correct button to close a connection for instance.
if(isset($_POST['submitb']))
{
	$invalid=false;

	$input = array($_POST['item'],$_POST['amount'],$_POST['days']);
	
	//verify data here in latter version...(for now assume it's verified)
	//this should be it's own function,as the calculate button,requires them
	//...maybe.
	for($i=0;$i<3;$i++)
	{
		//echo $input[$i];

		//$filter->clean_input($input[$i]);
		//shold just pass a pointer,thus no need
		//to move memory,just edit in place.Add this in latter version.
		
		//$filter->clean_input($input[0]); //this works,when not parsing variable i.
		$filter->clean_input($input[$i]); //works now?
		//echo "<br><br>";	
		//echo $input[$i];

		//this is working now...
		if($i==0)
		{
			if($filter->letters_only($input[$i])==-1)
			{
				$invalid=true;
				break; //it's breakinghere, so we do recieve an error
					//have an invisible attribute we make appear, to remind
				//the user what to enter, and disappears when user submits correctly.
			}

		}
		if($i==1 || $i==2)
		{
			if($filter->numbers_only($input[$i])==-1)
			{
				$invalid=true; break;
			}	
		}

	}


	/*test see if cleaning works*/
	//$input[0] = htmlspecialchars(stripslashes(trim($input[0]))); //this works.
//	$input[0]=trim($input[0]);	//trim removes whitespace
//	$input[0]=stripslashes($input[0]);	//removes backslashes
//	$input[0]=htmlspecialchars($input[0]);//converts some predefined characters to html entities
//	echo "<br>" . $input[0]; echo $input[1]; echo $input[2];

	if($invalid==false)
	{
		//database usage
		$ration->connect_to_db();
		$ration->create_database();
		$ration->add_table();
		$ration->insert_data($input);
		$ration->view_data();
		$ration->disconnect_from_db();
		
		//echo javascript to hide button
		/*echo '<script>',
			'alert("TESTING");',
			'document.getElementById("add").style.display=`"hidden";',
			'</script>';*/
	}
}

if(isset($_POST['deleteb']))
{
	//verify data here,we only want to verify that for this, the item field has to be a number
	//for the record id
	$input=array($_POST['item']);

	//database usage
	$ration->connect_to_db();
	$ration->delete_data($input);
	$ration->view_data();
	$ration->disconnect_from_db();
	
}
 
//could replace button to 'new' and delete and autocreate
if(isset($_POST['delete_tableb']))
{
	$ration->connect_to_db();
	$ration->delete_table();
	//$ration->delete_database(); this is causing an error
	$ration->disconnect_from_db();	
}
 
?>
 
</head>

<body>

<!--action is blank so we redirect onto itself, as it's a one-page application. -->
<form action="" method="post">
<form action="" method="post">
<label>Food Item</label>
<input type="text" id="item" name="item" value="String"><br><br>
<label for amount>Grams</label>
<input type="text" id="amount" name="amount" value="Number"><br><br>
<label for days>Days</label>
<input type="text" id="days" name="days" value="Number"><br><br>
<button type="button" onclick="myFunction()">calculate</button>
<input type="submit" id="add" value="Add/Update" name="submitb"/>
<input type="submit" value="delete" name="deleteb"/>
<input type="submit" value="delete table" name="delete_tableb"/>
</form>

<p id="result"></p>

<!--could call javascript onclick
for the same button for sending the data,'add' just adding in some javascript as proof of use/knowledge
rather than just php-->

</body>
</html>
