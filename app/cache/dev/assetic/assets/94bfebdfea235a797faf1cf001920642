disableDeparts(document.getElementById('etudiant_annee').value);

function mailINSA(){
	var nom=document.getElementById('etudiant_name').value.split(' ').join('-');
	alert(nom);	
	
	var prenom=document.getElementById('etudiant_firstName').value.split(' ').join('-');

	document.getElementById('etudiant_mail').value=prenom.toLowerCase()+'.'+nom.toLowerCase()+'@insa-lyon.fr';
}

function disableDeparts(annee){

	var options = document.getElementById('etudiant_departement').options;
	for(i=0;i<options.length;i++){
		var value=options[i].value;
		if(annee==1 || annee==2)
		{
			if(value=='PC')
			{
				options[i].disabled=false;
			} else
			{
				options[i].disabled=true;
			}
		}else
		{
			if(value!='PC')
			{
				options[i].disabled=false;
			} else
			{
				options[i].disabled=true;
			}
		}
	}
}

$(document).ready(function() 
{
	$('#etudiant_name').focus();
});
