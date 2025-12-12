// listar_itens.js - versão completa com exclusão assíncrona
let todosItens = []; // Armazena todos os itens carregados do servidor

// Carrega itens do servidor
async function carregarItens() {
    try {
        const situacao = document.getElementById('filtrosituacao')?.value || 'todos';
        const url = `index.php?pagina=api_listar_itens&situacao=${encodeURIComponent(situacao)}`;
        const response = await fetch(url);
        if (!response.ok) throw new Error('Erro HTTP ' + response.status);

        const data = await response.json();
        if (!data.sucesso) throw new Error(data.erro || 'Erro desconhecido');

        todosItens = data.itens; // Armazena globalmente
        filtrarERenderizar();
    } catch (error) {
        console.error('Erro ao carregar itens:', error);
        document.getElementById('gradeItens').innerHTML =
            '<p style="grid-column:1/-1;text-align:center;color:#c62828">Erro ao carregar itens: ' + error.message + '</p>';
    }
}

// Filtra itens por busca e categoria e renderiza
function filtrarERenderizar() {
    const busca = document.getElementById('campoBusca')?.value.toLowerCase() || '';
    const categoria = document.getElementById('filtroCategoria')?.value || 'todos';

    const itensFiltrados = todosItens.filter(item => {
        const combinaBusca = busca === '' ||
            item.nome.toLowerCase().includes(busca) ||
            item.descricao.toLowerCase().includes(busca);
        const combinaCategoria = categoria === 'todos' || (item.categoria || 'outro').toLowerCase() === categoria.toLowerCase();
        return combinaBusca && combinaCategoria;
    });

    renderizarItens(itensFiltrados);
    atualizarContagem(itensFiltrados.length);
}

// Renderiza os itens na tela
function renderizarItens(itens) {
    const grade = document.getElementById('gradeItens');
    if (itens.length === 0) {
        grade.innerHTML = '<p style="grid-column:1/-1;text-align:center;color:#666">Nenhum item encontrado.</p>';
        return;
    }

    grade.innerHTML = itens.map(item => {
        const statusClass = item.situacao.toLowerCase() === 'achado' ? 'achado' : 'perdido';
        const corBorda = statusClass === 'achado' ? '#4CAF50' : '#f44336';
        const foto = item.foto ? 'uploads/' + item.foto : 'img/sem_foto.png';
        const descricaoCurta = item.descricao_curta || (item.descricao.length > 80 ? item.descricao.substr(0, 80) + '...' : item.descricao);

        return `
        <div class="cartao" style="display:inline-block; width:220px; margin:10px; border:2px solid ${corBorda}; border-radius:8px; background:#033f0f; color:white; vertical-align:top; text-align:center; padding:10px;">
            <img src="${foto}" alt="${item.nome}" style="width:100%; height:auto; border-radius:4px; margin-bottom:5px;">
            <h3 style="font-size:1rem;">${item.nome} - ${item.cor}</h3>
            <p style="font-size:0.9rem;">${descricaoCurta}</p>
            <p style="font-size:0.8rem;"><strong>${item.situacao}</strong></p>
            <p style="font-size:0.8rem;">Achador: <strong>${item.achador}</strong></p>
            <div style="margin-top:5px;">
               <a href="index.php?pagina=excluir_item&id=<?= $item['id_item'] ?>" 
                    onclick="return confirm('Tem certeza que deseja excluir este item?');"
                    style="padding:5px 10px; background:#8b0000; color:white; border-radius:4px; text-decoration:none;">
                    Excluir
                </a>
            </div>
        </div>`;
    }).join('');
}

// Atualiza a contagem de itens
function atualizarContagem(total) {
    const p = document.querySelector('.resultado-info');
    if (p) {
        p.textContent = `${total} item${total !== 1 ? 'ns' : ''} encontrado${total !== 1 ? 's' : ''} em IFTO Campus - Colinas`;
    }
}

// Função de exclusão de item
async function excluirItem(id_item) {
    if (!confirm('Tem certeza que deseja excluir este item?')) return;

    try {
        const response = await fetch(`index.php?pagina=excluir_item&id=${id_item}`);
        const data = await response.json();

        if (data.sucesso) {
            // Remove o item do array local e re-renderiza
            todosItens = todosItens.filter(i => i.id_item !== id_item);
            filtrarERenderizar();
        } else {
            alert('Erro: ' + (data.erro || 'Falha ao excluir item'));
        }
    } catch (error) {
        alert('Erro ao excluir item: ' + error.message);
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    carregarItens();

    const filtroSituacao = document.getElementById('filtrosituacao');
    if (filtroSituacao) filtroSituacao.addEventListener('change', filtrarERenderizar);

    const filtroCategoria = document.getElementById('filtroCategoria');
    if (filtroCategoria) filtroCategoria.addEventListener('change', filtrarERenderizar);

    const campoBusca = document.getElementById('campoBusca');
    if (campoBusca) {
        campoBusca.addEventListener('input', filtrarERenderizar);
        campoBusca.addEventListener('keypress', e => {
            if (e.key === 'Enter') filtrarERenderizar();
        });
    }

    const btnBuscar = document.getElementById('btnBuscar');
    if (btnBuscar) btnBuscar.addEventListener('click', filtrarERenderizar);
});
