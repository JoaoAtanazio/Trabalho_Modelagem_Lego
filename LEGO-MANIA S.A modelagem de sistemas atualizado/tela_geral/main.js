document.addEventListener('DOMContentLoaded', function() {
	// Configuração do cursor
	const mainCursor = document.querySelector('.custom-cursor.site-wide');
	const defaultPointer = mainCursor.querySelector('.pointer');
	const customPointer = mainCursor.querySelector('.custom-pointer');
	
	const clickableElements = [
	  'a', 'button', '[onclick]', 
	  '.dropdown-button', '.btn', 
	  '.btn_menu', 'input[type="submit"]',
	  'label[for]', '.flatpickr-day'
	];
	
	document.addEventListener('mousemove', (e) => {
	  mainCursor.style.left = `${e.clientX}px`;
	  mainCursor.style.top = `${e.clientY}px`;
	});
	
	document.querySelectorAll(clickableElements.join(',')).forEach(el => {
	  el.addEventListener('mouseenter', () => {
		defaultPointer.style.display = 'none';
		customPointer.style.display = 'block';
	  });
	  
	  el.addEventListener('mouseleave', () => {
		customPointer.style.display = 'none';
		defaultPointer.style.display = 'block';
	  });
	});
	
	document.addEventListener('mouseout', (e) => {
	  if (!e.relatedTarget || e.relatedTarget === document.documentElement) {
		defaultPointer.style.display = 'block';
		customPointer.style.display = 'none';
	  }
	});
  
	// Configuração do Flatpickr com tratamento especial para o cursor
	flatpickr("#data-recebimento", {
	  dateFormat: "d/m/Y",
	  locale: "pt",
	  allowInput: true,
	  clickOpens: true,
	  onOpen: function(selectedDates, dateStr, instance) {
		// Ajusta o cursor quando o calendário abre
		defaultPointer.style.display = 'block';
		customPointer.style.display = 'none';
		
		// Adiciona eventos para os dias do calendário
		const days = instance.calendarContainer.querySelectorAll('.flatpickr-day');
		days.forEach(day => {
		  day.addEventListener('mouseenter', () => {
			defaultPointer.style.display = 'none';
			customPointer.style.display = 'block';
		  });
		  
		  day.addEventListener('mouseleave', () => {
			customPointer.style.display = 'none';
			defaultPointer.style.display = 'block';
		  });
		});
	  },
	  onClose: function() {
		// Restaura o cursor padrão quando o calendário fecha
		defaultPointer.style.display = 'block';
		customPointer.style.display = 'none';
	  }
	});
  });
  
  // Restante do seu código (event listeners para os botões)
  const conferirOS = document.getElementById("conferir");
  const voltarOS = document.getElementById("btnvoltaros");
  
  if (conferirOS) {
	conferirOS.addEventListener('click', AbrirOS);
  }
  
  if (voltarOS) {
	voltarOS.addEventListener('click', VoltarOS);
  }
  
  function AbrirOS(event) {
	event.preventDefault();
	window.location.href = '../Ordem_Servico/ordem_abertas.html';
  }
  
  function VoltarOS(event) {
	event.preventDefault();
	window.location.href = '../tela_geral/tela_geral.html';
  }