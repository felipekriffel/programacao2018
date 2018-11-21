var divCategoria = document.querySelector(".lista-categorias ol")
var divPosts = document.querySelector("section.posts")
var divPostDetail = document.querySelector("section.post-detail")

divPostDetail.querySelector("button").addEventListener("click", switchPostDetail)

function switchPostDetail(){
    if(divPostDetail.style.width=="70vw"){
        divPostDetail.style.width="0"        
    }else{
        divPostDetail.style.width="70vw"
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

        titulo.addEventListener("click", requestPostDetail)
            // console.log(ev.currentTarget.parentNode.dataset.idPost)
            // let request = await fetch("../../api/post/read.php?idPost="+ev.currentTarget.parentNode.dataset.idPost, { method: 'GET'})
            // let postObject = await request.json()
            // console.log(postObject[0])

        // })

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
        
        titulo.addEventListener("click",requestPostDetail)

        artigo.appendChild(titulo)
        artigo.appendChild(texto)
        
        divPosts.appendChild(artigo)
    });
}

async function requestPostDetail(ev){
    console.log(ev.currentTarget.parentNode.dataset.idPost)
    let request = await fetch("../../api/post/read.php?idPost="+ev.currentTarget.parentNode.dataset.idPost, { method: 'GET'})
    let postObject = await request.json()
    console.log(postObject[0])


    divPostDetail.children[0].children[0].innerText = postObject[0].titulo_post
    divPostDetail.children[1].innerText = postObject[0].texto_post

    let categoria = document.createElement("span")
    categoria.innerText = postObject[0].nome_categoria

    divPostDetail.children[2].innerHTML=""
    divPostDetail.children[2].appendChild(categoria)

    switchPostDetail()
}

async function requestWeatherData(lat, lng){
    navigator.geolocation.getCurrentPosition(async pos=>{
        let request = await fetch(`http://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&units=metric&lang=pt&APPID=c144ba4eaa5f0aebc01c661169701dc7`,{mode: "cors"})
        let data = await request.json()
        let widget = document.querySelector("header .tempo")
        widget.querySelector("p").innerText = `${data.name} ${data.main.temp}º`
    })

}

navigator.geolocation.getCurrentPosition(pos=>{
    requestWeatherData(pos.coords.latitude, pos.coords.longitude)
})

requestPosts()
requestCategories()