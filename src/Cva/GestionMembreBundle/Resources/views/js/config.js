/**
 * Load data from an url to an content in the nodes.
 * @param editUrl The url which has to be opened
 * @param id	  The id where this data should be loaded
 */
function load(editUrl,id){
	$.get(editUrl,
		function(msg){
			$(document.getElementById(id)).html(msg);
		}
	);
}

function insertAjoutBung() {

	$.get("ajoutBung",
	function(msg){
		$("#insertBung").html(msg);
	});
}

function insertEditBung(idBung) {

	$.get("editBung?idBung=" + idBung,
	function(msg){
		$("#insertBung").html(msg);
	});
}