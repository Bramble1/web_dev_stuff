using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using project2.Models;
using MySql.Data.MySqlClient;
using Dapper;
using System.Data.SqlClient;
using Microsoft.AspNetCore.Http;
using System.Web;
//using System.Web.Mvc;

namespace project2.Pages.Forms;

public class AddAddressModel : PageModel
{
	[BindProperty]
	public InputModel Input {get;set;}

	[BindProperty]
	public BirdsModel BirdDB {get;set;}

	public void OnGet()
	{
	
	}


	//works with the javascript,however javascript is stuck
	//in loop and keeps submitting,this should be triggered once
	//if the user clicks on a link, then we extract the name
	//from the highligted text and send it etc.
	//
	//also need code to list the names from the database as clickable
	//item list to then perform the javascript prior

	//we do the usual of putting the name in the url
	//so when the javascript is called, it is supplied with a url
	//and then we obtian it? maybe...

	public IActionResult OnPost()
	{

		//if not empty,then assume the link has been clicked rather
		//than search been used Need to a forr loop to contruct
		//the links from the database of birdnames as well.
		//
		//the logic layout for this needs to be completely changed
		//
		//ISSUE: when the link is pressed we are redirecred back to the same page
		//but this time with the parameter in the url, however no search, even after clicking
		//the link again, it only works if we click the link to load the url with a parameter and
		//then perform any random search for another post request again, in order to load.
		//
		//
		//
		//HANG on, i may not even need a web link, just generate a clickable list of names from the databse
		//and if clicked are tied to a c# function which retrieves the name from the name of the clicable
		//link to use as the normal database search and perform the normal display as usualy , as if they
		//posted maybe?
		//
		string birdname="";
		if(!String.IsNullOrEmpty(HttpContext.Request.Query["bird"])){
			birdname=HttpContext.Request.Query["bird"];

			BirdDB.cs=@"server=localhost;userid=username;password=password;database=BritishBirds;";
			BirdDB.open_connection();

			var birds = BirdDB.select_all(birdname);
			if(birds.Any())
			{
				ViewData["bird"]=birds[0];
				ViewData["image"]=birds[0].image;
			}

			BirdDB.close_connection();

			//return Page();

		}
	
		//ViewData["text"]=birdname;
		

		//ViewData["test"]="https://www.lovethegarden.com/sites/default/files/content/articles/UK_wildbirds-01-robin.jpg";
		//ViewData["test"]="~/bird.jpg";
		//ViewData["image"]="\"~/blackbird.jpeg\"";

		if(Input.letters_only()==-1)
		{
			ViewData["error"]="BirdName can only contain letters!";		
		}
		else
		{
			BirdDB.cs=@"server=localhost;userid=username;password=password;database=BritishBirds;";
			BirdDB.open_connection();

			var birds = BirdDB.select_all(Input.buffer);
			if(birds.Any()){
				ViewData["bird"]=birds[0];
				ViewData["image"]=birds[0].image;
				//ViewData["image"]="~/blackbird.jpeg";
			}
		//	ViewData["bird"]=BirdDB.select_single(Input.buffer);
		//	ViewData["bird"]= BirdDB.select_single("BlackBird"); //need to account for partial matches
			BirdDB.close_connection();
		}

		List<dynamic> Birds = BirdDB.construct_list();
		ViewData["list"]=Birds;//Birds[0];
		//ViewData["list"]=@{"<p>hello</p>"};
		//ViewData["object"]=BirdDB;
		if(ModelState.IsValid==false)
		{
			return Page();
		}

		return RedirectToPage("/Index");
	}

/*	static public void retrieve_list()
	{
		List<dynamic> birds = BirdDB.construct_list();
		ViewData["list"]=birds[0];
	}*/
}
