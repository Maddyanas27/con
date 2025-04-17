$(document).ready(function() {
    $('.increase_number, .decrease_number').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var row = button.closest('tr');
        var cartId = button.attr('attr_id');
        var newQuantity = parseInt(button.attr('attr_pro'));
        var price = parseFloat(row.find('.column-3').text().replace('Rs.', ''));

        // Update quantity in database
        $.ajax({
            url: 'ajax/update_cart_quantity.php',
            type: 'POST',
            data: {
                cart_id: cartId,
                quantity: newQuantity
            },
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if(result.success) {
                        // Update quantity input
                        row.find('.num-product').val(newQuantity);
                        
                        // Update row total
                        var rowTotal = price * newQuantity;
                        row.find('.column-5').text('Rs.' + rowTotal);

                        // Update buttons
                        row.find('.decrease_number').attr('attr_pro', Math.max(1, newQuantity - 1));
                        row.find('.increase_number').attr('attr_pro', newQuantity + 1);

                        // Update cart total
                        updateCartTotal();
                    }
                } catch(e) {
                    console.error('Error:', e);
                }
            }
        });
    });
});

function updateCartTotal() {
    $.ajax({
        url: 'ajax/get_cart_total.php',
        type: 'GET',
        success: function(response) {
            try {
                var result = JSON.parse(response);
                // Update subtotal
                $('.bor12 .mtext-110.cl2').text('Rs.' + result.total);
                // Update final total
                $('.p-t-27 .mtext-110.cl2').text('Rs.' + result.total);
            } catch(e) {
                console.error('Error:', e);
            }
        }
    });
}