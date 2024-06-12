document.getElementById('menu__toggle').addEventListener('change', function() {
    document.querySelector('.container').classList.toggle('menu-open', this.checked);
});