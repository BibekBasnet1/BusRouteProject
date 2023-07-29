
// selecting moon image
const darkMode = document.querySelector(".fa-moon");

// selecting login up button
const login_btn = document.querySelector(".login");

const form_element = document.querySelector(".form-container");

const sign_btn = document.querySelector(".sign-Up");

const sign_in_form_element = document.querySelector('.form-form');

darkMode.addEventListener('click',()=>{
    document.body.style.backgroundColor = "#0F0C29";
    document.body.style.color = "white";
})

// as soon as user clicks the signIn button
login_btn.addEventListener('click',()=>{
    form_element.style.display = "inline";
})

// as soon as user clicks the login button
sign_btn.addEventListener('click',()=>{
    sign_in_form_element.style.display = "inline";
})

// event listener on the burger menu
// for the sidebar section
const toggleBtn = document.querySelector(".sidebar-toggle");
console.log(toggleBtn);
const closeBtn = document.querySelector(".close-btn");
const sidebar = document.querySelector(".sidebar");

toggleBtn.addEventListener("click", function() {
    sidebar.classList.toggle("show-sidebar");
    sidebar.style.zIndex = 1;
});

closeBtn.addEventListener("click", function() {
    sidebar.classList.remove("show-sidebar");
});

// this is for form pop up in big smartphones tablets
const sign = document.querySelector('.sign');
const log = document.querySelector('.log');
sign.addEventListener('click',()=>{
    sign_in_form_element.style.display = "inline";
});

// this is for form pop up in big smartphones tablets
log.addEventListener('click',()=>{
    form_element.style.display = 'inline';
});








