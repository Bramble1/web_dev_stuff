using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace project2.Models;

/*filter and security class */

/*User input processing*/
public class InputModel
{
	public string buffer {get;set;}

//	public void clean_input(){}

	public int letters_only()
	{
		/*check each letter and if we encounter a number then exit
		 * thus best case being 1, and worst case being n length
		 *
		 * best case: theta(1).
		 * Worst case:O(n)
		 *
		 *
		 * if buffer is empty return
		 * */

		if(this.buffer.Length>0){

		for(int i=0;i<this.buffer.Length;i++)
		{
			if((this.buffer[i]<65 || this.buffer[i]>90) && (this.buffer[i]<97 || this.buffer[i]>122) && this.buffer[i]!=32)
			{
				return -1;	//-1 means buffer contains a non ascii letter,which is not a space.
			}	
		}
		}

		return 0;	//normal, contains only letters and spaces
	}

	public int numbers_only()
	{
		/*worst case:O(n) to identify a non numerical byte.
		 * best case:theta(1) to identify a non numerical byte.
		 *
		 *
		 * could increase performance by removing the -'0' instruction
		 * and comparing the initially numerically ascii values.
		 * */
		if(this.buffer.Length>0){
		for(int i=0;i<this.buffer.Length;i++)
		{
			if(this.buffer[i]-'0'<0 || this.buffer[i]-'0'>9)
			{
				return -1; 	//-1 means a non numerical value found
			}
		}
		}
		return 0;
	}


}
