const checkbox = document.getElementById('switch');

window.addEventListener('DOMContentLoaded', () => {
  const savedTheme = localStorage.getItem('theme');

  if (savedTheme === 'dark') {
    document.body.classList.add('dark-theme');
    checkbox.checked = true;
  } else {
    document.body.classList.remove('dark-theme');
    checkbox.checked = false;
  }
});

checkbox.addEventListener('change', () => {
  if (checkbox.checked) {
    // DARK MODE
    document.body.classList.add('dark-theme');
    localStorage.setItem('theme', 'dark');
  } else {
    // LIGHT MODE
    document.body.classList.remove('dark-theme');
    localStorage.setItem('theme', 'light');
  }
});

