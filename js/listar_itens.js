// Função para carregar itens do servidor
async function carregarItens(situacao = 'todos', busca = '') {
    try {
        let url = 'listar_itens.php?situacao=' + encodeURIComponent(situacao);
        if (busca) url += '&busca=' + encodeURIComponent(busca);

        const response = await fetch(url);
        if (!response.ok) throw new Error('Erro HTTP ' + response.status);

        const data = await response.json();
        if (!data.sucesso) throw new Error(data.erro || 'Erro desconhecido');

        renderizarItens(data.itens, data.total);
        atualizarContagem(data.total);
    } catch (error) {
        console.error('Erro ao carregar itens:', error);
        document.getElementById('gradeItens').innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#c62828">Erro ao carregar itens: ' + error.message + '</p>';
    }
}

// Renderizar itens na página
function renderizarItens(itens, total) {
    const grade = document.getElementById('gradeItens');
    
    if (itens.length === 0) {
        grade.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#666">Nenhum item encontrado.</p>';
        return;
    }

    grade.innerHTML = itens.map(item => `
        <article class="cartao status-${item.situacao.toLowerCase()}">
            <div class="cartao-esquerda">
                <img src="${item.foto}" alt="${item.nome}" />
            </div>
            <div class="cartao-direita">
                <h3>${item.nome}</h3>
                <p>No dia <strong>${item.dataFormatada}</strong></p>
                <p><strong>${item.situacao}</strong></p>
                <p>Cor: <strong>${item.cor}</strong></p>
                <p>Quem achou: <strong>${item.achador}</strong></p>
                <p class="guardado">Guardado há <strong>${item.guardadoHa}</strong></p>
            </div>
        </article>
    `).join('');
}

// Atualizar contagem
function atualizarContagem(total) {
    const p = document.querySelector('.resultadodapesquisa');
    if (p) {
        p.textContent = `${total} item${total !== 1 ? 'ns' : ''} encontrado${total !== 1 ? 's' : ''} em IFTO Campus - Colinas`;
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    // Carregar itens ao abrir página
    carregarItens();

    // Filtro por situação
    const filtro = document.getElementById('filtrosituacao');
    if (filtro) {
        filtro.addEventListener('change', () => {
            const busca = document.getElementById('campoBusca')?.value || '';
            carregarItens(filtro.value, busca);
        });
    }

    // Busca
    const btnBuscar = document.getElementById('btnBuscar');
    const campoBusca = document.getElementById('campoBusca');
    if (btnBuscar) {
        btnBuscar.addEventListener('click', () => {
            const situacao = document.getElementById('filtrosituacao')?.value || 'todos';
            carregarItens(situacao, campoBusca.value);
        });
    }

    // Pressionar Enter na busca
    if (campoBusca) {
        campoBusca.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const situacao = document.getElementById('filtrosituacao')?.value || 'todos';
                carregarItens(situacao, campoBusca.value);
            }
        });
    }

    // Navegar entre páginas
    const irParateladelistasitens = () => {
        window.location.href = 'tela_cadastro_de_item.html';
    };
    const irParateladesolicitacoes = () => {
        window.location.href = 'tela_solicitacoes.html';
    };
    const irParateladedevolucao = () => {
        window.location.href = 'tela_devolucao.html';
    };

    window.irParateladelistasitens = irParateladelistasitens;
    window.irParateladesolicitacoes = irParateladesolicitacoes;
    window.irParateladedevolucao = irParateladedevolucao;

    // Mostrar notificação se ?success=1
    const params = new URLSearchParams(window.location.search);
    if (params.get('success') === '1') {
        const nome = params.get('nome') ? decodeURIComponent(params.get('nome')) : '';
        const box = document.getElementById('notification');
        const msg = document.getElementById('notif-message');
        if (box && msg) {
            msg.textContent = nome ? `Item "${nome}" cadastrado com sucesso!` : 'Item cadastrado com sucesso!';
            box.style.display = 'block';
            setTimeout(() => {
                box.style.opacity = 1;
                box.style.transition = 'opacity .6s';
                setTimeout(() => box.style.opacity = 0, 4400);
            }, 50);
        }
    }
});
