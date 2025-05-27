document.addEventListener('DOMContentLoaded', function() {
  // Elementos do modal
  const modalCartao = document.getElementById('modalCartao');
  const btnCartao = document.getElementById('btnCartao');
  const closeModal = document.querySelector('.close-modal');
  const btnVoltarModal = document.querySelector('.btn-voltar-modal');
  const formCartao = document.getElementById('formCartao');
  const tipoCartao = document.getElementById('tipoCartao');
  const parcelas = document.getElementById('parcelas');
  const valorParcela = document.getElementById('valorParcela');
  const btnvoltar = document.getElementById('btnvoltar');
  
  // Ao clicar no cartão
  btnCartao.addEventListener('click', function() {
      // Preenche os dados da ordem no modal
      document.getElementById('numeroOrdemModal').textContent = 
          document.getElementById('numeroOrdem').value || 'OS-2023-00542';
      document.getElementById('valorTotalModal').textContent = 
          document.getElementById('valorTotal').value || 'R$ 1.250,00';
      
      // Abre o modal
      modalCartao.style.display = 'block';
  });
  
  // Fechar modal
  closeModal.addEventListener('click', function() {
      modalCartao.style.display = 'none';
  });
  
  btnVoltarModal.addEventListener('click', function() {
      modalCartao.style.display = 'none';
  });
  
  btnvoltar.addEventListener('click', function() {
      window.history.back();
  });
  
  // Calcular valor da parcela
  parcelas.addEventListener('change', function() {
      const valorTotalText = document.getElementById('valorTotal').value || 'R$ 1.250,00';
      const valorTotal = parseFloat(valorTotalText.replace('R$ ', '').replace('.', '').replace(',', '.'));
      const numParcelas = parseInt(this.value);
      const valor = (valorTotal / numParcelas).toFixed(2);
      valorParcela.value = `R$ ${valor.replace('.', ',')}`;
  });
  
  // Formulário do cartão
  formCartao.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Lógica para processar o pagamento
      alert('Pagamento com cartão processado com sucesso!');
      modalCartao.style.display = 'none';
  });
  
  // Fechar modal ao clicar fora
  window.addEventListener('click', function(e) {
      if (e.target === modalCartao) {
          modalCartao.style.display = 'none';
      }
  });
});

// DAQUI PARA BAIXO É JAVASCRIPT DO PAGAMENTO FORMA PIX //

document.addEventListener('DOMContentLoaded', function () {
    // Elementos principais
    const modalPix = document.getElementById('modalPix');
    const btnPix = document.getElementById('btnPix');
    const closeModal = modalPix.querySelector('.close-modal');
    const btnVoltarModal = modalPix.querySelector('.btn-voltar-modal');
    const parcelas = modalPix.querySelector('#parcelas');
    const valorParcela = modalPix.querySelector('#valorParcela');
    const pagpix = modalPix.querySelector('#pagpix');
    const qrCodeContainer = document.getElementById('qrcodePix');

    // Abrir modal ao clicar no botão
    btnPix.addEventListener('click', function () {
        // Tenta obter valores de inputs externos
        const numeroOrdemInput = document.getElementById('numeroOrdem');
        const valorTotalInput = document.getElementById('valorTotal');

        // Usa os valores dos inputs, ou valores padrão se não existir
        const numeroOrdemValor = numeroOrdemInput ? numeroOrdemInput.value : 'OS-2023-00542';
        const valorTotalValor = valorTotalInput ? valorTotalInput.value : 'R$ 1.250,00';

        // Preenche os dados no modal Pix
        document.getElementById('numeroOrdemModal').textContent = numeroOrdemValor;
        document.getElementById('valorTotalModal').textContent = valorTotalValor;

        // Limpa QR code anterior se houver
        if (qrCodeContainer) qrCodeContainer.innerHTML = '';

        // Abre o modal
        modalPix.style.display = 'block';
    });

    // Fechar modal ao clicar no "X"
    closeModal.addEventListener('click', function () {
        modalPix.style.display = 'none';
    });

    // Fechar modal ao clicar em "Voltar"
    btnVoltarModal.addEventListener('click', function () {
        modalPix.style.display = 'none';
    });

    // Fechar ao clicar fora do conteúdo
    window.addEventListener('click', function (e) {
        if (e.target === modalPix) {
            modalPix.style.display = 'none';
        }
    });

    // Calcular valor da parcela ao alterar o select
    parcelas.addEventListener('change', function () {
        const valorTotalText = document.getElementById('valorTotal')?.value || 'R$ 1.250,00';
        const valorTotal = parseFloat(valorTotalText.replace('R$ ', '').replace(/\./g, '').replace(',', '.'));
        const numParcelas = parseInt(this.value);
        const valor = (valorTotal / numParcelas).toFixed(2);
        valorParcela.value = `R$ ${valor.replace('.', ',')}`;
    });

    // Geração do QR Code e confirmação do pagamento
    pagpix.addEventListener('click', function (e) {
        e.preventDefault(); // Impede o envio do formulário

        // Obter valores
        const numeroOrdem = document.getElementById('numeroOrdem')?.value || 'OS-2023-00542';
        const valorTotal = document.getElementById('valorTotal')?.value || 'R$ 1.250,00';

        // Texto do QR Code (simples)
        const qrTexto = `Pagamento via PIX\nOrdem: ${numeroOrdem}\nValor: ${valorTotal}`;

        // Limpa QR Code anterior
        if (qrCodeContainer) qrCodeContainer.innerHTML = '';

        // Gera o QR Code
        new QRCode(qrCodeContainer, {
            text: qrTexto,
            width: 200,
            height: 200,
        });

        alert('QR Code gerado com sucesso!');
    });
});

