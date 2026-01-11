$(document).ready(function () {

    if (typeof alertify !== "undefined") {
        alertify.set('notifier','position', 'top-right');
    }

    $(document).on('click', '.increment, .decrement', function () {

        let qtyBox = $(this).closest('.qtyBox');
        let qtyInput = qtyBox.find('.qty');
        let productId = qtyBox.find('.prodId').val();

        let qty = parseInt(qtyInput.val());

        if ($(this).hasClass('increment')) {
            qty++;
        } else {
            if (qty > 1) qty--;
        }

        qtyInput.val(qty);

        $.ajax({
            url: 'orders-code.php',
            type: 'POST',
            dataType: 'json',
            data: {
                productIncDec: true,
                product_id: productId,
                quantity: qty
            },
            success: function (res) {

                if (res.status === 200) {
                    qtyBox.closest('tr')
                        .find('.totalPrice')
                        .text(res.total.toLocaleString());

                    alertify.success(res.message);
                } else {
                    alertify.error(res.message);
                }
            }
        });
    });

});
