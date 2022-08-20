
var spanConta = document.querySelector('#contaNumero');

function showModal() {

    $(document).on('click', '.link-modal', function (e) {
        e.preventDefault();
        var idConta = $(this).data('idconta');
        var numeroConta = $(this).data('numeroconta');

        var conta = document.querySelector('#conta').value = idConta;
        spanConta.innerText = numeroConta;

    });
}
var msg = document.querySelector('#message').innerText;
var alerts = document.querySelector('#alert').innerText;
var title = document.querySelector('#status').innerText;

$(window).on("load", function () {
    loadToast(title,msg,alerts)   
});

function loadToast(title,body,bg) {

    $(document).Toasts('create', {
        icon: 'fas fa-exclamation-triangle',
        class: `bg-${bg} m-1 width-500`,
        autohide: true,
        delay: 3000,
        title: title,        
        body: body,
        close:false,
        autoremove:true
    });
}



