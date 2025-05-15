document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll('.btn_menu');

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const submenu = button.nextElementSibling;
      const isActive = submenu.classList.contains('active');

      // Fecha todos os submenus
      document.querySelectorAll('.submenu').forEach(menu => {
        menu.classList.remove('active');
      });

      // Se o submenu clicado não estava aberto, abre ele
      if (!isActive) {
        submenu.classList.add('active');
      }
    });
  });
});