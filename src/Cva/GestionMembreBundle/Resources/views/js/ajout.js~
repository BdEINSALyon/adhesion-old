disableDeparts(document.getElementById('etudiant_annee').value);

accentsTidy = function(s)
{
	var r=s.toLowerCase();
//	r = r.replace(new RegExp(/\s/g),"");
	r = r.replace(new RegExp(/[àáâãäå]/g),"a");
	r = r.replace(new RegExp(/æ/g),"ae");
	r = r.replace(new RegExp(/ç/g),"c");
	r = r.replace(new RegExp(/[èéêë]/g),"e");
	r = r.replace(new RegExp(/[ìíîï]/g),"i");
	r = r.replace(new RegExp(/ñ/g),"n");                
	r = r.replace(new RegExp(/[òóôõö]/g),"o");
	r = r.replace(new RegExp(/œ/g),"oe");
	r = r.replace(new RegExp(/[ùúûü]/g),"u");
	r = r.replace(new RegExp(/[ýÿ]/g),"y");
//	r = r.replace(new RegExp(/\W/g),"");
	return r;
};

function mailINSA(){
	var nom=document.getElementById('etudiant_name').value.trim().split(' ').join('-');
	
	var prenom=document.getElementById('etudiant_firstName').value.trim().split(' ').join('-');

	document.getElementById('etudiant_mail').value=accentsTidy(prenom)+'.'+accentsTidy(nom)+'@insa-lyon.fr';
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
