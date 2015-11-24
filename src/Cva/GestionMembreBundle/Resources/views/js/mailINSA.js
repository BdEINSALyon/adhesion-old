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
	r = r.replace(new RegExp(/ /g),"-");
//	r = r.replace(new RegExp(/\W/g),"");
	return r;
};

function mailINSA(event){
	var $button = $(event.target);
	var $form = $button.closest('form');
	var $nameInput = $form.find('input[id$=\'_name\']');
	var $firstNameInput = $form.find('input[id$=\'_firstName\']');
	var nom=$nameInput.val().trim().split(' ').join('-');
	var prenom=$firstNameInput.val().trim().split(' ').join('-');
	$button.closest('.form-group').find('input').val(accentsTidy(prenom)+'.'+accentsTidy(nom)+'@insa-lyon.fr');
}

function mailInconnu(){
	document.getElementById('etudiant_mail').value='inconnu@inconnu.fr';
}

$(function(){
	$(document).on('click','.input-group-btn > button[data-mail="insa"]',mailINSA)
});