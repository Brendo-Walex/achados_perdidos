// Script para filtrar os itens por texto ou categoria

document.addEventListener("DOMContentLoaded", () => {
  const campoBusca = document.getElementById("campoBusca");
  const filtroCategoria = document.getElementById("filtroCategoria");
  const btnBuscar = document.getElementById("btnBuscar");
  const gradeItens = document.getElementById("gradeItens");
  const cartoes = Array.from(gradeItens.querySelectorAll(".cartao"));

  function filtrar() {
    const busca = campoBusca.value.toLowerCase();
    const categoria = filtroCategoria.value;

    let visiveis = 0;

    cartoes.forEach(cartao => {
      const titulo = cartao.getAttribute("data-titulo").toLowerCase();
      const cat = cartao.getAttribute("data-categoria").toLowerCase();
      const textoCartao = cartao.textContent.toLowerCase();

      const combinaBusca = busca === "" || titulo.includes(busca) || textoCartao.includes(busca);
      const combinaCategoria = categoria === "todos" || cat === categoria;

      if (combinaBusca && combinaCategoria) {
        cartao.style.display = "flex";
        visiveis++;
      } else {
        cartao.style.display = "none";
      }
    });

    // Atualiza a mensagem de resultado
    const info = document.querySelector(".resultado-info");
    info.textContent = `${visiveis} item${visiveis !== 1 ? "s" : ""} encontrados em IFES Campus - Colatina`;
  }

  btnBuscar.addEventListener("click", filtrar);
  campoBusca.addEventListener("input", filtrar);
  filtroCategoria.addEventListener("change", filtrar);

  // Ativar botão clicado
  document.querySelectorAll(".acoes .btn").forEach(btn => {
    btn.addEventListener("click", () => {
      document.querySelectorAll(".acoes .btn").forEach(b => b.classList.remove("ativo"));
      btn.classList.add("ativo");
    });
  });

  // Filtragem inicial
  filtrar();
});
