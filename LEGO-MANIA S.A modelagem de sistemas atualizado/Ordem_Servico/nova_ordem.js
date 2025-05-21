document.addEventListener('DOMContentLoaded', function() {
    // Configuração do datepicker
    flatpickr("#data", {
        dateFormat: "d/m/Y",
        locale: "pt",
        defaultDate: new Date()
    });

    // Formulário de cadastro
    const form = document.querySelector('.form-funcionario');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Coletar dados do formulário
        const novaOS = {
            id: Date.now(), // ID único baseado no timestamp
            nome: document.getElementById('nome').value,
            marca: document.getElementById('cpf').value,
            tempoUso: document.getElementById('salario').value,
            problema: document.getElementById('cep').value,
            observacao: document.getElementById('observacao').value,
            dataRecebimento: document.getElementById('data').value,
            status: 'ABERTA', // Status inicial
            tecnico: 'Não atribuído', // Técnico inicial
            prioridade: 'MÉDIA' // Prioridade padrão
        };

        // Salvar no localStorage
        salvarOS(novaOS);
        
        // Limpar formulário
        form.reset();
        
        // Feedback para o usuário
        alert('Ordem de Serviço cadastrada com sucesso!');
    });

    function salvarOS(os) {
        let ordens = JSON.parse(localStorage.getItem('ordensServico')) || [];
        ordens.push(os);
        localStorage.setItem('ordensServico', JSON.stringify(ordens));
    }

    // Botão Voltar
    document.getElementById('btnvoltaros').addEventListener('click', function() {
        window.location.href = '../tela_geral/tela_geral.html';
    });

    // Botão Conferir O.S
    document.getElementById('conferir').addEventListener('click', function() {
        window.location.href = 'ordem_abertas.html';
    });
});