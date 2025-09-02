const { jsPDF } = window.jspdf;
        
        function generatePDF() {
            // Criar instância do jsPDF
            const doc = new jsPDF();
            
            // Adicionar cabeçalho
            doc.setFontSize(20);
            doc.setTextColor(40, 40, 40);
            doc.text("Relatório de peças no estoque", 105, 20, { align: "center" });
            
            doc.setFontSize(12);
            doc.setTextColor(100, 100, 100);
            doc.text("Sistema de Gestão de Ordens de Serviço", 105, 28, { align: "center" });
            
            // Adicionar data de emissão
            const today = new Date();
            const dateStr = today.toLocaleDateString('pt-BR');
            doc.text(`Data de emissão: ${dateStr}`, 105, 35, { align: "center" });
            
            // Adicionar linha separadora
            doc.setDrawColor(200, 200, 200);
            doc.line(15, 40, 195, 40);
            
            // Adicionar resumo financeiro
            doc.setFontSize(16);
            doc.setTextColor(40, 40, 40);
            doc.text("Resumo de peças", 15, 50);
            
            doc.setFontSize(10);
            doc.setTextColor(100, 100, 100);
            doc.text("Total de peças: 128", 20, 60);
            doc.text("Em estoque: 94", 20, 67);
            doc.text("Estoque baixo: 22", 20, 74);
            doc.text("Fora do estoque:", 20, 81);
            
            // Adicionar tabela
            doc.setFontSize(16);
            doc.setTextColor(40, 40, 40);
            doc.text("Detalhamento das ultimas peças adicionadas ao estoque", 15, 95);
            
            // Extrair dados da tabela HTML
            const table = document.getElementById('ultimas-pecas-table');
            const data = [];
            
            // Cabeçalhos da tabela
            const headers = [];
            for (let i = 0; i < table.rows[0].cells.length; i++) {
                headers[i] = table.rows[0].cells[i].textContent;
            }
            data.push(headers);
            
            // Dados da tabela
            for (let i = 1; i < table.rows.length; i++) {
                const row = [];
                for (let j = 0; j < table.rows[i].cells.length; j++) {
                    row[j] = table.rows[i].cells[j].textContent;
                }
                data.push(row);
            }
            
            // Adicionar tabela ao PDF
            doc.autoTable({
    startY: 100,
    head: [[
        "Peça",
        "Categoria",
        "Estoque",
        "Status",
    ]],
    body: data.slice(1), // já está pronto no seu código
    theme: 'grid',
    styles: { fontSize: 9, cellPadding: 3, overflow: 'linebreak' },
    headStyles: {
        fillColor: [0, 0, 0],
        textColor: [255, 255, 255],
        halign: 'center',
        borderColor: [0, 0, 0],
    },
    tableWidth: "auto",  // ajusta ao conteúdo
    columnStyles: {
        0: { cellWidth: 40 },  // Peça
        1: { cellWidth: 30 },  // Categoria
        2: { cellWidth: 25 },  // Estoque
        3: { cellWidth: 23 },  // Fornecedor
    }
});

const tablepecas = document.getElementById('report-table');
            const datas = [];
            
            // Cabeçalhos da tabela
            const header = [];
            for (let i = 0; i < tablepecas.rows[0].cells.length; i++) {
                header[i] = tablepecas.rows[0].cells[i].textContent;
            }
            datas.push(header);
            
            // Dados da tabela
            for (let i = 1; i < tablepecas.rows.length; i++) {
                const row = [];
                for (let j = 0; j < tablepecas.rows[i].cells.length; j++) {
                    row[j] = tablepecas.rows[i].cells[j].textContent;
                }
                datas.push(row);
            }
            let finalY = doc.lastAutoTable.finalY + 15;
            // Adicionar tabela ao PDF
            doc.autoTable({
    startY: finalY,
    head: [[
        "ID",
        "Nome",
        "Categoria",
        "Fornecedor",
        "Estoque Atual",
        "Estoque Mínimo",
        "Status",
    ]],
    body: datas.slice(1), // já está pronto no seu código
    theme: 'grid',
    styles: { fontSize: 9, cellPadding: 3, overflow: 'linebreak' },
    headStyles: {
        fillColor: [0, 0, 0],
        textColor: [255, 255, 255],
        halign: 'center',
        borderColor: [0, 0, 0],
    },
    tableWidth: "auto",  // ajusta ao conteúdo
    columnStyles: {
        0: { cellWidth: 20 },  // ID
        1: { cellWidth: 30 },  // Nome
        2: { cellWidth: 20 },  // Categoria
        3: { cellWidth: 27 },  // Fornecedor
        4: { cellWidth: 20 },  // Estoque Atual
        5: { cellWidth: 20 },  // Estoque Mínimo
        6: { cellWidth: 23 },  // Status
    }
});
            
            // Adicionar rodapé
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(10);
                doc.setTextColor(100, 100, 100);
                doc.text(`Página ${i} de ${pageCount}`, 195, 285, { align: "right" });
                doc.text("SistemaOS - Relatórios de peças no estoque", 15, 285);
            }
            
            // Salvar o PDF
            doc.save(`relatorio_peças_no_estoque${dateStr.replace(/\//g, '-')}.pdf`);
        }
    