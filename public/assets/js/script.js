
var statusa = document.querySelector('#status').innerText;

if (statusa === ' Opps!') {
    $(window).on("load", function(){
        chamarToastError();
     });
} else{
    $(window).on("load", function(){
        chamarToastSucess();
     });
}

var spanConta = document.querySelector('#contaNumero');

function chamarToastSucess() {

    $(document).Toasts('create', {
      icon: 'fas fa-exclamation-triangle',
      class: 'bg-success m-1',
      autohide: true,
      delay: 5000,
      title: 'Parabéns!',
      body: 'Operação realizada com sucesso.'
    });
  }
function chamarToastError() {

    $(document).Toasts('create', {
      icon: 'fas fa-exclamation-triangle',
      class: 'bg-danger m-1',
      autohide: true,
      delay: 5000,
      title: 'Opss!',
      body: 'Erro(s) no preenchimento.'
    });
  }


function showModal() {

    $(document).on('click', '.link-modal', function (e) {
        e.preventDefault();
        var idConta = $(this).data('idconta');
        var numeroConta = $(this).data('numeroconta');

        var conta = document.querySelector('#conta').value = idConta;
        spanConta.textContent = numeroConta;

    });
}

