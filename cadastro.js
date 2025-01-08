// script para cadastrar o usuário e registrar no Firebase
document.getElementById("cadastro-form").addEventListener("submit", function (event) {
  event.preventDefault();

  // Obter os valores dos campos
  const nome = document.getElementById("nome").value;
  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

  // Criar um novo usuário no Firebase Auth
  firebase.auth().createUserWithEmailAndPassword(email, senha)
    .then((userCredential) => {
      const user = userCredential.user;

      // Salvar dados do usuário no Firestore
      const db = firebase.firestore();
      db.collection("users").doc(user.uid).set({
        nome: nome,
        email: email,
        status: "inativo", // Definindo status como inativo
        subscriptionActive: false,
        subscriptionEndDate: null
      })
      .then(() => {
        alert("Cadastro realizado com sucesso. Acesse o site após o pagamento.");
        window.location.href = "login.html"; // Redireciona para a página de login
      })
      .catch((error) => {
        console.error("Erro ao salvar dados no Firestore: ", error);
      });
    })
    .catch((error) => {
      console.error("Erro ao criar usuário: ", error.message);
      alert("Erro ao cadastrar usuário. Tente novamente.");
    });
});
