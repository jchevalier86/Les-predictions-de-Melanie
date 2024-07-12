// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.3/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.12.3/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyC5h23yxwllKYX1JhJ2JDjmt1F7-bRgaTY",
  authDomain: "les-predictions-de-melanie.firebaseapp.com",
  projectId: "les-predictions-de-melanie",
  storageBucket: "les-predictions-de-melanie.appspot.com",
  messagingSenderId: "995837523522",
  appId: "1:995837523522:web:117e9612fdd9fc83619fdb",
  measurementId: "G-HWJM6W2BEX",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

// document.addEventListener("DOMContentLoaded", function () {
//   // Supposons que l'inscription soit stockée dans le localStorage
//   const isRegistered = localStorage.getItem("isRegistered");

//   // Référence aux éléments HTML
//   const contactForm = document.getElementById("contactForm");
//   const notRegisteredMessage = document.getElementById("notRegisteredMessage");

//   // Vérification de l'inscription
//   if (isRegistered === "true") {
//     contactForm.style.display = "block";
//     notRegisteredMessage.style.display = "none";
//   } else {
//     contactForm.style.display = "none";
//     notRegisteredMessage.style.display = "block";
//   }
// });

// // Exemple de fonction pour simuler l'inscription (vous pouvez l'appeler via un autre bouton ou action)
// function registerUser() {
//   localStorage.setItem("isRegistered", "true");
//   alert("Vous êtes maintenant inscrit !");
//   // Recharge la page pour appliquer les changements
//   window.location.reload();
// }
