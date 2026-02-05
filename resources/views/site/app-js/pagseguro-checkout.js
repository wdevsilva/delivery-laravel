$("#parcelamento").hide();
$("#amount").val(totalCompra);
$(".cpf").mask("999.999.999-99 000");
$("#fakecartao_num").mask("9999 9999 9999 9999");
$("#cliente_nascimento").mask("99/99/9999");
$("#cartao_cod").on("blur", function () {
    $("#btn-finaliza-credito").text("Aguarde...");
});
$("#btn-finaliza-credito").on("click", function () {
    $("#btn-finaliza-credito").addClass("hide");
    $("#resp-pagamento").html(
        '<h3 class="text-center text-danger bold"><strong> Aguarde, processando pagamento...</strong></h3>'
    );
});

var form = document.getElementById("form-credito");
$(document).ready(function () {
    new Card({
        form: form,
        formSelectors: {
            numberInput: 'input[name="fakecartao_num"]',
            expiryInput: 'input[name="cartao_ano"]',
            cvcInput: 'input[name="cartao_cod"]',
            nameInput: 'input[name="cartao_nome"]',
        },
        placeholders: {
            number: "•••• •••• •••• ••••",
            name: "Nome do Titular",
            expiry: "••/••",
            cvc: "•••",
        },
        container: ".card-wrapper",
    });
});
PagSeguroDirectPayment.setSessionId(pagseguro_id);
PagSeguroDirectPayment.getPaymentMethods({
    amount: totalCompra,
    success: function (response) {
        jQuery.each(response["paymentMethods"], function (index, value) {
            //   console.log(index);
        });
    },
    error: function (response) {
        // console.log(response)
    },
    complete: function (response) {
        //console.log(response)
    },
});
