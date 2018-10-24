var divCategoria = document.querySelector(".lista-categorias ol")


async function requestCategories(){
    let request = await fetch("api/categoria/read.php", { method: 'GET'})
    let arrayCategorias = await request.json()

    arrayCategorias.forEach(categoria => {
        let liCategoria = document.createElement("li")
        let linkCategoria = document.createElement("a")

        linkCategoria.innerText = categoria.nome_categoria
        linkCategoria.href = `/categoria?id=${categoria.id_categoria}`

        liCategoria.appendChild(linkCategoria)
        divCategoria.appendChild(liCategoria)
    });
    console.log(arrayCategorias)
}

requestCategories()