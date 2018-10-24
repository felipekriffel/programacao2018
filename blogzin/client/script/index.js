var divPosts = document.querySelector("section.posts")

async function requestPosts() {
    let request = await fetch("api/post/read.php", { method: 'GET'})
    let arrayPosts = await request.json()

    arrayPosts.forEach(post => {
        let artigo = document.createElement("article")
        let titulo = document.createElement("h1")
        let texto = document.createElement("p")

        titulo.innerText = post.titulo_post
        texto.innerText = post.texto_post

        artigo.appendChild(titulo)
        artigo.appendChild(texto)
        
        divPosts.appendChild(artigo)
    });
    console.log(arrayPosts)
}

requestPosts()