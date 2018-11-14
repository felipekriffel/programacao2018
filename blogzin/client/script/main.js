var divCategoria = document.querySelector(".lista-categorias ol")
var divPosts = document.querySelector("section.posts")
var divPostDetail = document.querySelector("section.post-detail")

function switchPostDetail(){
    if(divPostDetail.style.width=="70%"){
        divPostDetail.style.width="0"        
    }else{
        divPostDetail.style.width="70%"
    }
}

async function requestCategories(){
    let request = await fetch("../../api/categoria/read.php", { method: 'GET'})
    let arrayCategorias = await request.json()

    arrayCategorias.forEach(categoria => {
        let liCategoria = document.createElement("li")
        let linkCategoria = document.createElement("button")

        linkCategoria.innerText = categoria.nome_categoria
        liCategoria.dataset.idCategoria = categoria.id_categoria
        
        liCategoria.addEventListener("click", async ev=>{
            requestPostsCategoria(ev.currentTarget.dataset.idCategoria)
        })

        liCategoria.appendChild(linkCategoria)
        divCategoria.appendChild(liCategoria)
    });
    // console.log(arrayCategorias)
}

async function requestPosts() {
    let request = await fetch("../../api/post/read.php", { method: 'GET'})
    let arrayPosts = await request.json()

    arrayPosts.forEach(post => {
        let artigo = document.createElement("article")
        let titulo = document.createElement("h1")
        let texto = document.createElement("p")

        titulo.innerText = post.titulo_post
        texto.innerText = post.texto_post
        artigo.dataset.idPost = post.id_post



        artigo.appendChild(titulo)
        artigo.appendChild(texto)
        
        divPosts.appendChild(artigo)
    });
    // console.log(arrayPosts)
}

async function requestPostsCategoria(idCat){
    let request = await fetch("../../api/post/read.php?idCategoria="+idCat, { method: 'GET'})
    let arrayPosts = await request.json()
    console.log(arrayPosts)

    divPosts.innerHTML = ""
    arrayPosts.forEach(post => {
        let artigo = document.createElement("article")
        let titulo = document.createElement("h1")
        let texto = document.createElement("p")

        titulo.innerText = post.titulo_post
        texto.innerText = post.texto_post
        artigo.dataset.idPost = post.id_post
        

        artigo.appendChild(titulo)
        artigo.appendChild(texto)
        
        divPosts.appendChild(artigo)
    });
}

requestPosts()
requestCategories()