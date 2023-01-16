// Load our customized validationjs library
import Validator from './validator'

// Create our own validator
var ValidatorPlus = function (form, rules, errorClass = 'validatorjs-error') {
    // Properties
    this.form = form
    this.rules = rules
    this.htmlErrors = {}
    this.htmlClassName = errorClass
    // Initialization
    this.init()
}

ValidatorPlus.prototype = {
    
    constructor: ValidatorPlus,

    init: function() {
        // Submit form ONLY when validation is OK
        const self = this
        this.form.addEventListener("submit", function( event ) {
            // Reset errors messages
            self.resetHtmlErrors()
            // Get form inputs values
            let inputs = this.elements
            let data = {}
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].nodeName === "INPUT" || 
                    inputs[i].nodeName === "TEXTAREA" || 
                    inputs[i].nodeName === "SELECT") {
                    let name = inputs[i].name
                    let value = inputs[i].value
                    data[name] = value
                }
            }
            // Create validation
            let validation = new Validator(data, self.rules)
            // Validate fields
            if (validation.passes()) {
                // Allow submit form (do nothing)
                console.log("Validation OK")
            } else {
                // Get error messages
                let errors = validation.errors.all()
                console.log(errors)
                // Show error messages
                for(let inputName in errors) {           
                    self.showHtmlError(inputName, errors[inputName])
                }
                // Avoid submit
                event.preventDefault()
                return false
            }
        })    
    },

    resetHtmlErrors: function(){
        for (let id in this.htmlErrors) {
            this.htmlErrors[id].innerHTML = ''
            this.htmlErrors[id].style.display = 'none'
        }
    },

    showHtmlError: function(inputName, message){
        let id = inputName + '-' + this.htmlClassName
        // Check if error node exists
        if (!this.htmlErrors[id]) {
            // Create node (once)
            let elem = document.createElement('div')
            elem.id = id
            elem.className = this.htmlClassName
            // Add node after input
            let input = document.getElementById(inputName)
            if (input) {
                input.after(elem);
            } else {
                console.log('ID "' + inputName + '" not found')
            }
            // Store node reference
            this.htmlErrors[id] = elem
        }
        // Update error message
        this.htmlErrors[id].innerHTML = message
        this.htmlErrors[id].style.display = 'block'
    }
}

export default ValidatorPlus