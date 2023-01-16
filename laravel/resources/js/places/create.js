// Load our customized validationjs library
import ValidatorPlus from '../validator-plus'

let form = document.getElementById("create-place")
let rules = {
    "name": "required|max:255",
    "description": "required|max:255",
    "upload": "required",
    "latitude": "required|numeric",
    "longitude": "required|numeric",
    "visibility": "required",

}
var MyValidator = new ValidatorPlus(form, rules, "alert alert-danger")