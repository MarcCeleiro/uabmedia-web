// BUSCADOR INTERNO DE LA WEB




//PASO1: declarar variables:

box_search = document.getElementById("box-search");
cover_ctn_search = document.getElementById("ctn-bars-search");
inputSearch = document.getElementById("inputSearch");
contingut = document.getElementsByClassName("contingut");

//PASO 2: crear funciones

//función para mostrar el buscador
function mostrar_buscador(){
	box_search.style.top=("80px");
	inputSearch.focus();
}

//función para ocultar el buscador al hacer clic fuera
function ocultar_buscador(){
	box_search.style.top=("-80px");
}

//PASO 3: Ejecutar funciones escritas debajo en el paso 3:
document.getElementById("icon-search").addEventListener("click", mostrar_buscador);

let elementos = document.getElementsByClassName("contingut");

for(let el of elementos) {
      el.addEventListener("click", ocultar_buscador)
    }



