document.addEventListener('DOMContentLoaded', function() {
    // Get the burger toggler element and the nav links container
    const burgerToggler = document.getElementById('menu-toggle');
    const navLinksContainer = document.getElementById('nav-links-container');
    const main = document.querySelector('main');
    const footer = document.querySelector('footer');

    // Define the toggleNav function, which toggles the 'open' class
    const toggleNav = e => {
        burgerToggler.classList.toggle('open');
        navLinksContainer.classList.toggle('open');
    }

    // Define the closeNav function, which remove the 'open' class
    const closeNav = e => {
        burgerToggler.classList.remove('open');
        navLinksContainer.classList.remove('open');
    }

    // Add a click event listener to the burger toggler element
    // that calls the toggleNav function when clicked
    burgerToggler.addEventListener('click', toggleNav);

    main.addEventListener('click', closeNav);
    footer.addEventListener('click', closeNav);

    window.addEventListener('scroll', closeNav);

    new ResizeObserver(entries => {
        if(entries[0].contentRect.width >= 992) {
            burgerToggler.classList.remove('open');
            navLinksContainer.classList.remove('open');
        }
    }).observe(document.body);

    // Handle password visibility toggle
    document.querySelectorAll(".eyes").forEach(eye => {
        eye.addEventListener("click", function(e) {
            e.preventDefault(); // Prevents the default click behavior (in case it's a link or button)

            // Find the associated password input by searching within the closest parent container
            const password = this.closest('.password-container').querySelector('.password');
            
            // Find the eye icon itself (the <i> tag inside the clicked element)
            const fas = this.querySelector('.eyesImag');

            // If the input field type is "password", change it to "text" to show the password
            if (password.type === 'password') {
                password.setAttribute('type', 'text'); // Change the input type to "text"
                fas.classList.remove('fa-eye-slash'); // Change the icon from "eye-slash" to "eye"
                fas.classList.add('fa-eye');
            } else {
                // If the input type is "text", change it back to "password" to hide the password
                password.setAttribute('type', 'password'); // Hide the password again
                fas.classList.add('fa-eye-slash'); // Switch back to the "eye-slash" icon
                fas.classList.remove('fa-eye');
            }

            // Automatically close the eye and hide the password again after 10 seconds
            window.setTimeout(function() {
                closeEyes(password, fas); // Call the function to reset the eye icon and hide the password
            }, 10000); // Delay of 10,000 milliseconds (10 seconds)
        });
    });

    // Function to reset the input type to "password" and restore the "eye-slash" icon
    function closeEyes(password, fas) {
        password.setAttribute('type', 'password'); // Hide the password again
        fas.classList.add('fa-eye-slash'); // Restore the "eye-slash" icon
        fas.classList.remove('fa-eye'); // Remove the "eye" icon
        fas.removeAttribute('style'); // Remove any inline styling (e.g., red color)
    }

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        var button = document.getElementById("backToTopButton");
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            button.style.display = "block";
        } else {
            button.style.display = "none";
        }
    }

    document.getElementById('backToTopButton').addEventListener('click', function() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
});
