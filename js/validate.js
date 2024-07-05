function validate(form)
{
fail = validateName(form.value);
/*fail += validateAddress(form.address.value);
fail += validateCity(form.city.value);
fail += validatePhone(form.tel.value);
fail += validateDistrict(form.district.value);
fail += validateEmail(form.email.value);
fail += validatePass(form.pass.value, form.passmatch.value);
fail += validateZipcode(form.zipcode.value);*/

if (fail == "") {return true}
else { alert(fail); return false }
}


function validateName(field)
{
  if (field == "") {return "Por favor, informe o seu nome.\n"; }
}

function validateAddress(field)
{
  if (field == "") {return "O campo Endereço é obrigatório.\n"; }
}

function validateCity(field)
{
  if (field == "") {return "O campo Cidade é obrigatório.\n"; }
}

/*function validatePhone(field) {
	
}*/

function validateDistrict(field)
{
  if (field == "") {return "Um Estado deve ser selecionado.\n"; }
}

function validateZipcode(field)
{
if (field == "") {return "O campo CEP é obrigatório.\n"; }
else if (field.lenght!=8) {return "inv\n";}
}

function validatePass(field, fieldmatch)
{
if (field == "") {return "Nenhuma senha de acesso informada.\n";}
else if (field != fieldmatch){ return "As senhas não convergem.\n"; }
else if (field.length < 6){
return "A senha deve ter pelo menos 6 dígitos.\n";}
//else if (!/[a-z]/.test(field) || ! /[A-Z]/.test(field) ||
//!/[0-9]/.test(field)) {
//return "Passwords require one each of a-z, A-Z and 0-9.\n"; }
else { return ""; }
}

function validateEmail(field)
{
if (field == "") {return "O campo E-mail é obrigatório..\n";}
else if (!((field.indexOf(".") > 0) &&
(field.indexOf("@") > 0)) ||
/[^a-zA-Z0-9.@_-]/.test(field)){
return "E-mail inválido.\n";}
else {return "";}
}
