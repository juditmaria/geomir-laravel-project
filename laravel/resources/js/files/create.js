// Load our customized validationjs library
import ValidatorPlus from '../validator-plus'

let form = document.getElementById("create-file")
let rules = {
    "upload": "required",
}
var MyValidator = new ValidatorPlus(form, rules, "alert alert-danger")