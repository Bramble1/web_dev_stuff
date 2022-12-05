using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using MySql.Data.MySqlClient;
//using MySql.Data.MySqlClient.SqlException;

using System.Data.SqlClient;
//using System.Data.SqlClient.SqlException;

using Dapper;
namespace project2.Models;

//convert this to abstract and inheritence once this proof of concept is done.
public abstract class DbModel
{
	//properties
	/*public int id {get;set;}
	public string name {get;set;}
	public string description {get;set;}
	public string size {get;set;}
	public string nest {get;set;}
	public string image {get;set;} */
	
	/*properties*/
	public string cs {get;set;}
	//protected 
	public MySqlConnection con{get;set;}

	//methods
	public void open_connection()
	{
		this.con = new MySqlConnection(this.cs);
		this.con.Open();
	}

	public void close_connection()
	{
		this.con.Close();
	}
	

//	public abstract string ToString();
	public abstract override string ToString();
	//{
		//add html break tags to organise the returned string
	//	return $"{id} {name} {description} {size} {nest} {image}";
	//}
}

public class BirdsModel : DbModel
{
	public int id {get;set;}
	public string name{get;set;}
	public string description{get;set;}
	public string size{get;set;}
	public string nest{get;set;}
	public string image{get;set;}

	public override string ToString()
	{
		return $"{name} {description} {size} {nest} {image}";	
	}

	public List<BirdsModel> select_all(string bname)
	{
		List<BirdsModel> birds = null;
		try
		{
			//List<BirdsModel> birds = this.con.Query<BirdsModel>("SELECT * FROM birds").ToList();
			birds = this.con.Query<BirdsModel>("SELECT * FROM birds where name=@name",new {name=bname}).ToList();
		}catch(SqlException ex)
		{
			//return "select query error";
		}
		return birds;
	}

	public List<dynamic> construct_list()
	{
		List<dynamic> birds = this.con.Query("SELECT name FROM birds").ToList();

		//iterate and find sprintf alternative
	/*	for(int i=0;i<birds.Count;i++)
		{
			birds[i] = string.Format("<a id=\"{0}\" onclick=\"auto_search(this)\" href=\"#\">{0}</a>",birds[i].name);
		} */		
		
		//birds.ForEach(birds =>

		return birds;
	}
}

//inherit from the abstract class for our customised sql class wrapper
//for the britishbirds database
