// {/* <i class="fa fa-star-half-o" aria-hidden="true"></i> */}
// $(".side-nav side-menu").hover(
//     $(this).append("<i class='fa fa-star-half-o'></i>")
// );

const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const signIncontainer = document.querySelector(".login100-form");
const signUpcontainer = document.querySelector(".signup100-form");

sign_up_btn.addEventListener("click", () => {
  signIncontainer.classList.add("sign-up-mode");
  signUpcontainer.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  signIncontainer.classList.remove("sign-up-mode");
  signUpcontainer.classList.remove("sign-up-mode");
});