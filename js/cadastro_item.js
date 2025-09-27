// Seleciona os elementos do DOM
const inputImagem = document.getElementById('imagem');
const preview = document.querySelector('.imagem-preview img');

// Adiciona evento de mudança de arquivo
inputImagem.addEventListener('change', function () {
  const arquivo = this.files[0];

  if (arquivo) {
    const leitor = new FileReader();

    leitor.addEventListener('load', function () {
      preview.src = leitor.result;
    });

    leitor.readAsDataURL(arquivo);
  } else {
    preview.src = 'https://via.placeholder.com/150';
  }
});
