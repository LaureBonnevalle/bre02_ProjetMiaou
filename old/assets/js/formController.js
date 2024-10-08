import { 
    validateEmail, 
    validateText,  
    validatePassword, 
    validateConfirmPassword,
} from './formFunctions.js';


document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            // Prevent the form from submitting by default
            event.preventDefault();

            // Reset error messages and styles
            const errorMessages = form.querySelectorAll('.error-message');
            errorMessages.forEach(function(msg) {
                msg.textContent = '';
            });

            let formValid = true;
            
            // Retrieve the new_password value before validation
            const newPasswordValue = form.querySelector("#new_password")?.value || '';

            // Check each field if present
            const fields = [
                { 
                    id              : "firstname", 
                    validate        : validateText, 
                    args            : [2, 60], 
                    errorMessage    : "Le prénom est requis.", 
                    invalidMessage  : "Le prénom doit contenir uniquement des lettres, entre 2 et 60 caractères."
                },
                { 
                    id              : "email", 
                    validate        : validateEmail, 
                    args            : [], 
                    errorMessage    : "L'email est requis.", 
                    invalidMessage  : "L'email n'est pas valide."
                },
                { 
                    id              : "token", 
                    validate        : value => value !== "", 
                    args            : [], 
                    errorMessage    : "Une erreur est survenue lors de l'envoi, actualisez le formulaire et soumettez votre demande une seconde fois !", 
                    invalidMessage  : ""
                },
                { 
                    id              : "password", 
                    validate        : validatePassword, 
                    args            : [], 
                    errorMessage    : "Le mot de passe est requis.", 
                    invalidMessage  : "Le mot de passe doit contenir au moins 8 caractères, dont une majuscule, une minuscule, un chiffre et un caractère spécial."
                },
                { 
                    id              : "old_password", 
                    validate        : validatePassword, 
                    args            : [12], 
                    errorMessage    : "Le mot de passe provisoire est requis.", 
                    invalidMessage  : "Le mot de passe provisoire qui vous a été envoyé doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."
                },
                { 
                    id              : "new_password", 
                    validate        : validatePassword, 
                    args            : [], 
                    errorMessage    : "Le mot de passe est requis.", 
                    invalidMessage  : "Votre nouveau mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."
                },
                { 
                    id              : "confirm_new_password", 
                    validate        : validateConfirmPassword,
                    args            : [newPasswordValue],      // Pass the value of "new_password" as an argument
                    errorMessage    : "Le mot de passe est requis.", 
                    invalidMessage  : "La confirmation de votre nouveau mot de passe doit être identique."
                },
            ];

            fields.forEach(field => {
                const inputElement = form.querySelector(`#${field.id}`);
                const errorElement = form.querySelector(`#error-${field.id}`);

                if (inputElement && errorElement) {
                    const value = inputElement.value.trim();
                    if (value === "") {
                        formValid = false;
                        errorElement.textContent = field.errorMessage;
                    } else if (!field.validate(value, ...field.args)) {
                        formValid = false;
                        errorElement.textContent = field.invalidMessage;
                    }

                    inputElement.addEventListener("input", function() {
                        errorElement.textContent = "";
                        inputElement.classList.remove("error");
                    });
                }
            });

            // If the form is valid, submit it
            if (formValid) {
                form.submit();
            }
        });
    });
});