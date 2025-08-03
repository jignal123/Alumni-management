const sidebarToggle = document.querySelector("#sidebar-toggle");
const sidebar = document.querySelector("#sidebar").classList;
sidebarToggle.addEventListener("click",function(){
    sidebar.toggle("collapsed");
});
