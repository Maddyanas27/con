document.addEventListener('DOMContentLoaded', function() {
    const addCartForm = document.getElementById('add_cart');
    
    if (addCartForm) {
        addCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('handle_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'shoping-cart.php';
                } else if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});