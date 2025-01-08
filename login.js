// script para autenticar o login do usuário no Firebase
document.getElementById("login-form").addEventListener("submit", function (event) {
  event.preventDefault();

  // Obter os valores dos campos
  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

  // Autenticar o usuário com Firebase Auth
  firebase.auth().signInWithEmailAndPassword(email, senha)
    .then((userCredential) => {
      const user = userCredential.user;

      // Verificar se o usuário está ativo
      const db = firebase.firestore();
      db.collection("users").doc(user.uid).get()
        .then((doc) => {
          if (doc.exists) {
            const userData = doc.data();

            if (userData.status === "ativo" && userData.subscriptionActive && userData.subscriptionEndDate > firebase.firestore.Timestamp.now()) {
              // O usuário está ativo e a assinatura está válida
              alert("Login bem-sucedido.");
              window.location.href = "index.html"; // Redireciona para a página principal
            } else {
              // Caso o usuário não tenha uma assinatura válida
              alert("Sua assinatura não está ativa ou não foi confirmada. Por favor, verifique.");
              firebase.auth().signOut();
            }
          }
        })
        .catch((error) => {
          console.error("Erro ao verificar status do usuário: ", error);
          alert("Erro ao verificar seu status. Tente novamente.");
        });
    })
    .catch((error) => {
      console.error("Erro ao fazer login: ", error.message);
      alert("Erro ao autenticar. Verifique suas credenciais e tente novamente.");
    });
});
