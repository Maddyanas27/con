$(document).ready(function() {
    // Handle quantity updates
    $('.increase_number, .decrease_number').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var row = button.closest('tr');
        var cartId = button.attr('attr_id');
        var newQuantity = parseInt(button.attr('attr_pro'));
        var price = parseFloat(row.find('.column-3').text().replace('Rs.', ''));

        $.ajax({
            url: 'ajax/update_cart.php',
            type: 'POST',
            data: { cart_id: cartId, quantity: newQuantity },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    // Update quantity display
                    row.find('.num-product').val(newQuantity);
                    
                    // Update row total
                    var rowTotal = (price * newQuantity).toFixed(2);
                    row.find('.column-5').text('Rs.' + rowTotal);
                    
                    // Update buttons
                    row.find('.decrease_number').attr('attr_pro', Math.max(1, newQuantity - 1));
                    row.find('.increase_number').attr('attr_pro', newQuantity + 1);
                    
                    // Update cart total
                    updateCartTotal();
                }
            }
        });
    });

    // Handle remove item from cart
    $('.cart_delete').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var cartId = button.attr('attr_id');
        var row = button.closest('tr');

        if(confirm('Are you sure you want to remove this item?')) {
            $.ajax({
                url: 'ajax/remove_cart_item.php',
                type: 'POST',
                data: { cart_id: cartId },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        // Remove the row with animation
                        row.fadeOut(300, function() {
                            $(this).remove();
                            // Update cart total
                            updateCartTotal();
                        });
                    } else {
                        alert('Error removing item from cart');
                    }
                },
                error: function() {
                    alert('Error communicating with server');
                }
            });
        }
    });

    function updateCartTotal() {
        $.ajax({
            url: 'ajax/get_cart_total.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Update all total amounts on the page
                $('.mtext-110.cl2').text('Rs.' + response.total);
            }
        });
    }
});