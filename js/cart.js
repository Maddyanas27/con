$(document).ready(function() {
    $('.increase_number, .decrease_number').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var id = button.attr('attr_id');
        var new_quantity = parseInt(button.attr('attr_pro'));
        var stock_count = parseInt(button.siblings('input').attr('max')) || 0;
        var price = parseFloat(button.closest('tr').find('.column-3').text().replace('Rs.', ''));
        
        // Validate quantity
        if (new_quantity < 1) new_quantity = 1;
        if (new_quantity > stock_count) {
            alert('Cannot exceed available stock quantity!');
            return false;
        }

        $.ajax({
            url: 'ajax/update_cart_quantity.php',
            type: 'POST',
            data: {
                cart_id: id,
                quantity: new_quantity
            },
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if(result.success) {
                        // Update quantity display
                        button.siblings('input').val(new_quantity);
                        
                        // Update row total
                        var newTotal = price * new_quantity;
                        button.closest('tr').find('.column-5').text('Rs.' + newTotal);
                        
                        // Update cart total
                        updateCartTotal();
                        
                        // Update button states
                        var increaseBtn = button.closest('.wrap-num-product').find('.increase_number');
                        if(new_quantity >= stock_count) {
                            increaseBtn.css({'pointer-events': 'none', 'opacity': '0.5'});
                        } else {
                            increaseBtn.css({'pointer-events': 'auto', 'opacity': '1'});
                        }
                    } else {
                        alert('Error updating quantity');
                    }
                } catch(e) {
                    console.error('Error:', e);
                }
            }
        });
    });

    function updateCartTotal() {
        $.ajax({
            url: 'ajax/get_cart_total.php',
            type: 'GET',
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    $('.size-209 .mtext-110.cl2').text('Rs.' + result.total);
                    $('.bor12 .size-209 .mtext-110.cl2').text('Rs.' + result.subtotal);
                } catch(e) {
                    console.error('Error:', e);
                }
            }
        });
    }
});