
let modl = document.querySelector(".modl");
let show = document.querySelector(".show");

let closeButton = document.querySelector(".close-button");
function toggleModal() {
    modl.classList.toggle("show-modal");
}
function windowOnClick(event) {
    if (event.target === modl) {
        toggleModal();
    }
}
show.addEventListener("click", toggleModal);
closeButton.addEventListener("click", toggleModal);
window.addEventListener("click", windowOnClick);