document.addEventListener("DOMContentLoaded", function(event) {
    const invoervelden = document.querySelectorAll('.geldinput');

    invoervelden.forEach(function(invoer) {
        invoer.addEventListener('input', function() {
            // Verwijder alle tekens behalve cijfers en komma's
            this.value = this.value.replace(/[^\d.]/g, '');

            // Formateer het eerste deel met punten voor duizendtallen
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Voeg de delen weer samen
            this.value = parts.join(',');

            // Voeg ",00" toe als er nog geen komma in de invoer staat
            if (!this.value.includes(',')) {
                this.value += ',00';
            }

            // Verplaats de cursor naar het einde van de invoer
            this.setSelectionRange(this.value.length, this.value.length);
        });
    });
});
