//Registrar listener
document.addEventListener('DOMContentLoaded', function () { 

    eventListeners();

    darkMode();
});
function eventListeners() { 
    const mobileMenu = document.querySelector('.mobile-menu');
    //Si clickea el menu responsive
    mobileMenu.addEventListener('click', navegacionResponsive);
}
function navegacionResponsive() { 
    //Obtener el elemento que se quiere mostrar
    const navegacion = document.querySelector('.navegacion');

    if (navegacion.classList.contains('mostrar')) { 
        //Si tiene la clase mostrar, se la quitamos
        navegacion.classList.remove('mostrar');
    } else { 
        //Si no la tiene, se la agregamos
        navegacion.classList.add('mostrar');
    }
    
}
function darkMode() { 
    //Si el usuario tiene por defecto el dark mode en su Sistema Operativo
    const preferenciaDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    if(preferenciaDarkMode.matches) { 
        document.body.classList.add('dark-mode');
    } else { 
        document.body.classList.remove('dark-mode');
    } 
    //Si el usuario cambia la preferencia de su Sistema Operativo se actualiza la pagina.
    preferenciaDarkMode.addEventListener('change', function () { 
        if (preferenciaDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    //Obtener el boton de dark mode
    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });
}