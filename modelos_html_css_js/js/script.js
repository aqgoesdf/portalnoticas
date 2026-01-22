const noticias = [
    {
        titulo: "Manchete Principal do Dia",
        resumo: "Resumo da principal notícia do portal.",
        iamgem: "img/img-destaque",
        categoria: "Brasil",
        destaque: true
    },

    {
        titulo: "Economia cresce acima do esperado",
        resumo: "Especialistas analisam os números do trimestre.",
        imagem: "img/noticia1.jpg",
        categoria: "Economia",
        destaque: false
    },

    {
         titulo: "Novo avanço na tecnologia nacional",
        resumo: "Inovação promete impactar o mercado.",
        imagem: "img/noticia2.jpg",
        categoria: "Tecnologia",
        destaque: false
    },

    {
        titulo: "Clássico decide o campeonato",
        resumo: "Torcida lota o estádio no jogo decisivo.",
        imagem: "img/noticia3.jpg",
        categoria: "Esportes",
        destaque: false
    },

];

const destaque = document.getElementById("destaque");
const secundarias = document.getElementById("secundarias");
const lista_noticias = document.getElementById("lista-noticias");


function carregarDestaque(){
    const noticiaDestaque = noticias.find(n => n.destaque);
    destaque.innerHTML = `
        <article>
            <img src="${noticiaDestaque.imagem}">
            <h2>${noticiaDestaque.titulo}</h2>
            <p>${noticiaDestaque.resumo}</p>

        </article>
    `;
}

function carregarSecundarias(){
    const secundariasNoticias = noticias.filter (n => !n.destaque);

    secundarias.innerHTML = "";

    secundariasNoticias.forEach(noticia => {
        secundarias.innerHTML += `
        <article> 
             <img src="${noticia.imagem}">
            <h3>${noticia.titulo}</h3>
            <p>${noticia.resumo}</p> 
            </article>
            `;
    });

}


function carregarLista(){
    listanoticias.innerHTML = "";

    noticias.forEach(noticia => {
        listanoticias.innerHTML += `
            <article>
              <h3>${noticia.titulo}</h3>
              <p>${noticia.resumo}</p>
            </article>

        `;
    });
}

carregarDestaque();
carregarSecundarias();
carregarLista();