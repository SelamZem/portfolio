document.addEventListener("DOMContentLoaded", function() {
    
    const cards = document.querySelectorAll('.admin-card');
    cards.forEach(card => {
        card.addEventListener('mouseover', function() {
            this.style.transform = 'scale(1.05)';
            this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        });
        card.addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
        });
    });

    // Add further interactive behaviors here if needed
    const logoutButton = document.getElementById('admin-logout');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to logout?')) {
                event.preventDefault();
            }
        });
    }
});
