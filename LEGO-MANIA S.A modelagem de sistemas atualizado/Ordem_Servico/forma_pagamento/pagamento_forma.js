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
      
      // Aqui você pode adicionar a lógica para processar o pagamento
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