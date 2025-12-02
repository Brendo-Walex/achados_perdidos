// Função para carregar solicitações do servidor
async function carregarSolicitacoes(situacao = 'todos', busca = '') {
    try {
        let url = 'listar_solicitacoes.php?situacao=' + encodeURIComponent(situacao);
        if (busca) url += '&busca=' + encodeURIComponent(busca);

        const response = await fetch(url);
        if (!response.ok) throw new Error('Erro HTTP ' + response.status);

        const data = await response.json();
        if (!data.sucesso) throw new Error(data.erro || 'Erro desconhecido');

        renderizarSolicitacoes(data.solicitacoes, data.total);
        atualizarContagem(data.total);
    } catch (error) {
        console.error('Erro ao carregar solicitações:', error);
        document.querySelector('.lista').innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#c62828">Erro ao carregar solicitações: ' + error.message + '</p>';
    }
}

// Renderizar solicitações na página
function renderizarSolicitacoes(solicitacoes, total) {
    const lista = document.querySelector('.lista');
    
    if (solicitacoes.length === 0) {
        lista.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#666">Nenhuma solicitação encontrada.</p>';
        return;
    }

    lista.innerHTML = solicitacoes.map(sol => `
        <article class="cartao">
            <div class="cartao-left">
                <img src="${sol.fotoItem}" alt="${sol.nomeItem}" />
            </div>

            <div class="cartao-right">
                <div class="solicitante">
                    <div class="label-solicitado">Solicitado por <strong>${sol.nomeSolicitante}</strong></div>
                    <div class="contato email">${sol.email}</div>
                    <div class="contato celular">${sol.telefone}</div>
                    <div class="contato dtnasc">${sol.dataNascimento}</div>
                </div>

                <p class="descricao">
                    ${sol.descricao}
                </p>

                <div class="acoes-cartao">
                    ${sol.anexo ? `<button class="btn-pequeno" onclick="abrirAnexo('${sol.anexo}')">Ver Anexo</button>` : ''}
                </div>

                <div class="info-item">
                    <h3 class="titulo-item">${sol.nomeItem}</h3>
                    <div class="data">No dia <span class="data-destaque">${sol.dataItem}</span></div>
                    <div class="status-item status-${sol.situacao.toLowerCase()}" style="margin-top:8px;font-weight:bold">
                        ${sol.situacao}
                    </div>
                </div>

                ${sol.perguntaItem ? `
                <div class="pergunta">
                    <strong>"${sol.perguntaItem}"</strong>
                    ${sol.respostaSolicitante ? `<div class="resposta">${sol.respostaSolicitante}</div>` : '<div class="resposta" style="color:#c62828">Sem resposta</div>'}
                </div>
                ` : ''}

                <div style="margin-top:12px;padding-top:12px;border-top:1px solid #ddd;font-size:12px;color:#666">
                    Solicitação em: ${sol.dataSolicitacao}
                </div>
            </div>
        </article>
    `).join('');
}

// Abrir anexo
function abrirAnexo(caminho) {
    window.open(caminho, '_blank');
}

// Atualizar contagem
function atualizarContagem(total) {
    const p = document.querySelector('.resultadodapesquisa');
    if (p) {
        p.textContent = `${total} solicitação${total !== 1 ? 'ões' : ''} em IFTO Campus - Colinas`;
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Carregar solicitações ao abrir página
    carregarSolicitacoes();

    // Filtro por situação
    const filtro = document.getElementById('filtrosituacao');
    if (filtro) {
        filtro.addEventListener('change', () => {
            const busca = document.getElementById('campoBusca')?.value || '';
            carregarSolicitacoes(filtro.value, busca);
        });
    }

    // Busca
    const btnBuscar = document.getElementById('btnBuscar');
    const campoBusca = document.getElementById('campoBusca');
    if (btnBuscar) {
        btnBuscar.addEventListener('click', () => {
            const situacao = document.getElementById('filtrosituacao')?.value || 'todos';
            carregarSolicitacoes(situacao, campoBusca.value);
        });
    }

    // Pressionar Enter na busca
    if (campoBusca) {
        campoBusca.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const situacao = document.getElementById('filtrosituacao')?.value || 'todos';
                carregarSolicitacoes(situacao, campoBusca.value);
            }
        });
    }

    // Navegar entre páginas
    window.irParateladelistasitens = () => {
        window.location.href = 'tela_cadastro_de_item.html';
    };
    window.irParateladesolicitacoes = () => {
        window.location.href = 'tela_listagem_de_itens.html';
    };
    window.irParateladedevolucao = () => {
        window.location.href = 'tela_devolucao.html';
    };
});
