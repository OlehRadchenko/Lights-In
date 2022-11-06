function Drop_login() {
    document.getElementById("HeaderNav-dropLogin").classList.toggle("show"); 
}
    
    document.getElementById("HeaderNav-dropLogin").addEventListener('click', function (event) {
        event.stopPropagation();
    });
    
    window.onclick = function(event) {
        if (!event.target.matches('#Login-loginBtn')) {
        
            var dropdowns =
            document.getElementsByClassName("HeaderNav-dropLogin");          
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }