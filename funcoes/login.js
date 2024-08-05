function mostrarsenha() {
    const inputPass = document.getElementById('senha');
    const iconeOlho = document.getElementById('iconeOlho');


    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
    } else {
        inputPass.setAttribute('type', 'password');
    }
}
function fazerLogin() {
    const email = document.getElementById("email").value;
    const senha = document.getElementById("senha").value;
    const somsim = new Audio('./som/login_sucesso.mp3');
    const somnao = new Audio('./som/login_erro.mp3');

    if (email === "") {
        somnao.play();
        Swal.fire({
            icon: "error",
            title: "Email Não Digitado!",
            showConfirmButton: false,
        });
        return;
    } else if (senha === "") {
        somnao.play();
        Swal.fire({
            icon: "error",
            title: "Senha Não Digitada!",
            showConfirmButton: false,
        });
        return;
    }else if (senha.length < 8) {
        somnao.play();
        Swal.fire({
            icon: "error",
            title: "A Senha Necessita de 8 Dígitos!",
            showConfirmButton: false,
        });
        return;
    } else{

    }
    fetch("login_back.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body:
            "email=" +
            encodeURIComponent(email) +
            "&senha=" +
            encodeURIComponent(senha),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            if (data.success) {
                somsim.play();
                Swal.fire({
                    icon: "success",
                    title: "Login Realizado com Sucesso!",
                    showConfirmButton: false,
                });
                setTimeout(function () {
                    window.location.href = "dashboard.php";
                }, 1000);
            } else {
                somnao.play();
                Swal.fire({
                    icon: "error",
                    title: data.message,
                    text: "(Clique no Cadeado para Visualizar a Senha)",
                    showConfirmButton: false,
                });
            }
        })
        .catch((error) => {
            console.error("Erro na requisição", error);
        });
}

const cliqueemail = new Audio('./som/clique.wav');
const cliquesenha = new Audio('./som/clique.wav');

document.getElementById("email").addEventListener('click', function (){
    cliqueemail.currentTime = 0;
    cliqueemail.play();
});
document.getElementById("senha").addEventListener('click', function (){
    cliquesenha.currentTime = 0;
    cliquesenha.play();
});



const somtecla = new Audio('./som/digitacao.wav');

const input = document.getElementById('email');
input.addEventListener('keydown', function (){
    somtecla.currentTime = 0;
    somtecla.play();
});

const inputsenha = document.getElementById('senha');
inputsenha.addEventListener('keydown', function (){
    somtecla.currentTime = 0;
    somtecla.play();
});


