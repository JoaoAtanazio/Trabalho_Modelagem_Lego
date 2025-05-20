document.addEventListener('DOMContentLoaded', function() {
    let informações = [
        {
            Nome_Usuário: 'bananinhas123',
            Nome_Novo: '',
            SenhaAntiga: 'admin123',
            SenhaNova: '',
            email: 'bananinhas@gmail.com'
        }
    ];

    // Elementos do DOM
    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-form');
    const closeBtn = document.querySelector('.close-btn');
    const editButtons = document.querySelectorAll('.btn-editar'); 
    const nome = document.getElementById('edit-Nome')
    const senhaAntiga = document.getElementById('edit-Senha')
    const senhaNova = document.getElementById('edit-SenhaNova')
    const btnSalvar = document.getElementById('btnsalva')
   
    function openModal() {
        // Preenche os campos com os dados atuais
        nome.value = '';
        senhaAntiga.value = '';
        senhaNova.value = '';
        editModal.style.display = 'block';
    }

    function closeModal() {
        editModal.style.display = 'none';
        editForm.reset();
    }
    // Evento para fechar ao clicar fora do modal
    window.addEventListener('click', function(event) {
        if (event.target === editModal) {
            closeModal();
        }
    });

    editButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });

    closeBtn.addEventListener('click', closeModal);
    btnSalvar.addEventListener('click', ValidaSenha)
     

    function ValidaSenha(){
        if (senhaNova.length < 6) {
            alert('A senha deve ter pelo menos 6 caracteres');
            return;
          }}

})