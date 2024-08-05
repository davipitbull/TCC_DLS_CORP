// Função para carregar o conteúdo da página
function carregaMenu(page) {
    fetch('controle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'controle=' + encodeURIComponent(page),
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('carregaConteudo').innerHTML = data;
    })
    .catch(error => console.error('Erro na requisição:', error));
}

// Função para validar CPF
function ValidaCPF() {
    var RegraValida = document.getElementById("cpf_usuario").value;
    var cpfValido = /^(([0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2})|([0-9]{11}))$/;
    if (cpfValido.test(RegraValida)) {
        console.log("CPF Válido");
    } else {
        console.log("CPF Inválido");
    }
}

// Função para aplicar máscara ao CPF
function fMasc(objeto, mascara) {
    obj = objeto;
    masc = mascara;
    setTimeout(() => fMascEx(), 1);
}

function fMascEx() {
    obj.value = masc(obj.value);
}

// Função para formatar CPF
function mCPF(cpf_usuario) {
    cpf_usuario = cpf_usuario.replace(/\D/g, "");
    cpf_usuario = cpf_usuario.replace(/(\d{3})(\d)/, "$1.$2");
    cpf_usuario = cpf_usuario.replace(/(\d{3})(\d)/, "$1.$2");
    cpf_usuario = cpf_usuario.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return cpf_usuario;
}

// Verifica se o campo CPF está presente na página e aplica a máscara
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById("cpf_usuario")) {
        document.getElementById("cpf_usuario").addEventListener('input', function () {
            fMasc(this, mCPF);
        });
    }

    // Configura a navegação lateral para adicionar a classe "pressed"
    var aside = document.getElementById('show-side-navigation1');
    if (aside) {
        var elements = aside.querySelectorAll('li');

        elements.forEach(function (element) {
            element.addEventListener('click', function () {
                element.classList.add('pressed');

                setTimeout(function () {
                    element.classList.remove('pressed');
                }, 100); // Tempo em milissegundos para remover a classe "pressed"
            });
        });
    }
});

// Função para sair e redirecionar para a página inicial
function sair() {
    window.location.href = "index.php";
}

// Função para abrir o modal de exclusão
function abrirModalJsExcluir(id, inID, nomeModal, abrirModal = 'A', addEditDel, formulario) {
    const formDados = document.getElementById(formulario);
    const ModalInstacia = new bootstrap.Modal(document.getElementById(nomeModal));

    if (abrirModal === 'A') {
        ModalInstacia.show();

        if (inID !== 'nao') {
            document.getElementById(inID).value = id;
        }

        const submitHandler = function (event) {
            event.preventDefault();
            const formData = new FormData(formDados);
            formData.append('controle', addEditDel);

            if (inID !== 'nao') {
                formData.append('id', id);
            }

            fetch('excusuario.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                location.reload();
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                location.reload();
            });
        };

        formDados.addEventListener('submit', submitHandler);
    } else {
        location.reload();
    }
}

// Função para abrir o modal de alteração
function abrirModalJsAlterar(id, inID, nomeModal, abrirModal = 'A', addEditDel, formulario, idNome, inNome, idCpf, inCpf, idAtivo, InAtivo) {
    const formDados = document.getElementById(formulario);
    const modalElement = document.getElementById(nomeModal);
    const ModalInstacia = new bootstrap.Modal(modalElement);

    if (abrirModal === 'A') {
        ModalInstacia.show();

        if (inNome !== 'nao') {
            document.getElementById(inNome).value = idNome;
        }
        if (inCpf !== 'nao') {
            document.getElementById(inCpf).value = idCpf;
        }
        if (inID !== 'nao') {
            document.getElementById(inID).value = id;
        }
        if (InAtivo !== 'nao') {
            document.getElementById(InAtivo).value = idAtivo;
        }

        const submitHandler = function (event) {
            event.preventDefault();
            const formData = new FormData(formDados);
            formData.append('controle', addEditDel);

            if (inID !== 'nao') {
                formData.append('id', id);
            }

            fetch('alterarusuario.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                location.reload();
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                location.reload();
            });
        };

        formDados.addEventListener('submit', submitHandler);
    } else {
        location.reload();
    }
}

// Função para abrir o modal de visualização
function abrirModalJsVerMais(id, inID, nomeModal, abrirModal = 'A') {
    const modalElement = document.getElementById(nomeModal);
    const ModalInstacia = new bootstrap.Modal(modalElement);

    if (abrirModal === 'A') {
        ModalInstacia.show();

        if (inID !== 'nao') {
            document.getElementById(inID).value = id;
        }

        const submitHandler = function (event) {
            event.preventDefault();
        };

        document.getElementById(formulario).addEventListener('submit', submitHandler);
    } else {
        location.reload();
    }
}
