$(document).ready(function() {
    // Handle quantity changes
    $('.increase_number, .decrease_number').on('click', function(e) {
        e.preventDefault();
        var $button = $(this);
        var $row = $button.closest('tr');
        var cartId = $button.attr('attr_id');
        var newQuantity = parseInt($button.attr('attr_pro'));
        var unitPrice = parseFloat($row.find('.column-3').text().replace('Rs.', ''));

        // Update database
        updateQuantity(cartId, newQuantity, function(success) {
            if (success) {
                // Update quantity input
                $row.find('.num-product').val(newQuantity);
                
                // Update row total
                var rowTotal = (unitPrice * newQuantity).toFixed(2);
                $row.find('.column-5').text('Rs.' + rowTotal);
                
                // Update buttons
                $row.find('.decrease_number').attr('attr_pro', Math.max(1, newQuantity - 1));
                $row.find('.increase_number').attr('attr_pro', newQuantity + 1);
                
                // Update cart totals
                updateCartTotals();
            }
        });
    });
});

function updateQuantity(cartId, quantity, callback) {
    $.ajax({
        url: 'ajax/update_quantity.php',
        type: 'POST',
        data: {
            cart_id: cartId,
            quantity: quantity
        },
        success: function(response) {
            try {
                var result = JSON.parse(response);
                callback(result.success);
            } catch(e) {
                console.error('Error:', e);
                callback(false);
            }
        },
        error: function() {
            callback(false);
        }
    });
}

function updateCartTotals() {
    $.ajax({
        url: 'ajax/get_totals.php',
        type: 'GET',
        success: function(response) {
            try {
                var result = JSON.parse(response);
                // Update all total amounts
                $('.bor12 .mtext-110.cl2').text('Rs.' + result.total);
                $('.p-t-27 .mtext-110.cl2').text('Rs.' + result.total);
            } catch(e) {
                console.error('Error:', e);
            }
        }
    });
}