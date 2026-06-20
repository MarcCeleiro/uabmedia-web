// CERCADOR INTERN DE LA WEB




//PAS 1: declarar variables:

box_search = document.getElementById("box-search");
cover_ctn_search = document.getElementById("ctn-bars-search");
inputSearch = document.getElementById("inputSearch");
contingut = document.getElementsByClassName("contingut");

//PAS 2: crear funcions

//funció per mostrar el cercador
function mostrar_buscador(){
	box_search.style.top=("80px");
	inputSearch.focus();
}

//funció per amagar el cercador en fer clic fora
function ocultar_buscador(){
	box_search.style.top=("-80px");
}

//PAS 3: Executar les funcions escrites a sota al pas 3:
document.getElementById("icon-search").addEventListener("click", mostrar_buscador);

let elementos = document.getElementsByClassName("contingut");

for(let el of elementos) {
      el.addEventListener("click", ocultar_buscador)
    }



