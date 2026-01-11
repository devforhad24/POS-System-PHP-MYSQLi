$(document).ready(function () {
  if (typeof alertify !== "undefined") {
    alertify.set("notifier", "position", "top-right");
  }

  $(document).on("click", ".increment, .decrement", function () {
    let qtyBox = $(this).closest(".qtyBox");
    let qtyInput = qtyBox.find(".qty");
    let productId = qtyBox.find(".prodId").val();

    let qty = parseInt(qtyInput.val());

    if ($(this).hasClass("increment")) {
      qty++;
    } else {
      if (qty > 1) qty--;
    }

    qtyInput.val(qty);

    $.ajax({
      url: "orders-code.php",
      type: "POST",
      dataType: "json",
      data: {
        productIncDec: true,
        product_id: productId,
        quantity: qty,
      },
      success: function (res) {
        if (res.status === 200) {
          qtyBox
            .closest("tr")
            .find(".totalPrice")
            .text(res.total.toLocaleString());

          alertify.success(res.message);
        } else {
          alertify.error(res.message);
        }
      },
    });
  });

  $(document).on("click", ".proceedToPlace", function () {
    var cphone = $("#cphone").val();
    var payment_mode = $("#payment_mode").val();
    if (payment_mode == "") {
      swal("Select Payment Mode", "Select your payment mode", "warning");
      return false;
    }
    if (cphone == "" && !$.isNumeric(cphone)) {
      swal("Enter phone number", "Enter valid phone number", "warning");
      return false;
    }
    var data = {
      proceedToPlaceBtn: true,
      cphone: cphone,
      payment_mode: payment_mode,
    };
    $.ajax({
      type: "POST",
      url: "orders-code.php",
      data: data,
      success: function (response) {
        var res = JSON.parse(response);
        if (res.status == 200) {
          window.location.href = "order-summary.php";
        } else if (res.status == 404) {
          swal(res.message, res.message, res.status_type, {
            buttons: {
              catch: { text: "Add Customer", value: "catch" },
              cancel: "Cancel",
            },
          }).then((value) => {
            switch (value) {
              case "catch":
                $('#addCustomerModal').modal('show');
                // console.log("Pop the customer add modal");
                break;
              default:
            }
          });
        } else {
          swal(res.message, res.message, res.status_type);
        }
      },
    });
  });
});
