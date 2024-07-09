<?php

function validateName($field) {
        if ($field == "") { 
              return "name^O nome deve ser informado*"; }
        elseif (preg_match('/[0-9.@_-]/', $field)>0) {return "name^Por favor, o seu nome completo*";}
        elseif (preg_match('/\s/', $field)!=true) {return "name^Por favor, o seu nome completo*";}
        else {return $field."-okcp8RY5Mc58name*";}
}

function validateAddress($field)
{
  if ($field == "") { return "address^Informe o endereço*";}
  else {
  return $field."-okcp8RY5Mc58address*";}
}

function insertComplement($field)
{
  return $field."-okcp8RY5Mc58complement*";
}

function validateCity($field)
{
  if ($field == "") { return "city^Informe a cidade*";}
  else {
  return $field."-okcp8RY5Mc58city*";}
}

function validateEmail($field)
{
	if ($field=="") {
		return $field."email^Você deve informar um e-mail*"	;
	}
	else if (preg_match("/([a-zA-Z0-9.@_-])+@+([a-zA-Z0-9.@_-])*\.+([a-zA-Z0-9.@_-])*/", $field)==true)
	{
		return $field."-okcp8RY5Mc58email*";	//vagab
	}
	else {
		return "email^Por favor, insira um e-mail válido*"; //aaah o problematico acha q eh pra ele.... se quiser;;;
	}
}

function validatePhone($field)
{
	if($field=="") {return "tel^Você deve informar um telefone*";}  //vagab
	//else if (strlen($field)!=11 || strlen($field)!=10) {return "tel^Você deve informar um telefone válido*";}
	else {return $field."-okcp8RY5Mc58tel*"; }

}

function validatePass($field, $fieldmatch)
{
if ($field == "") {return "pass^Nenhuma senha de acesso informada*";}
else if ($field != $fieldmatch){ return "pass^As senhas não convergem*"; }
else if (strlen($field) < 6){
return "pass^A senha deve ter pelo menos 6 dígitos*";}
else if (!preg_match('/[a-z]/',$field) ||
!preg_match('/[0-9]/',$field) || preg_match('/[.@_-]/',$field)) {
return "pass^A senha deve conter números e letras*"; }
else { return $field."-okcp8RY5Mc58pass*"; }
}

function validateZipcode($field)
{
     if ($field == "") { return "zipcode^Por favor, informe o CEP*";}
     else if (strlen($field) != 8) { return "zipcode^CEP inválido*"; }
     else { return $field."-okcp8RY5Mc58zipcode*";}
}


function ca($field) {
  $fator = 5;
  $total = 0;
    for($i=0; $i<12; $i++) {
        $total += $field[$i]*$fator;
        $fator--;
        if($fator=2) {$fator=9;}} 
  $rest = $total%11;
  if($rest<2){$x=0;}
  else {$x= 11-$rest;}
 return $x;
}

function caa($field) {
$fator2 = 6;
$total2 = 0;
for($j=0; $j<13; $j++) {
$total2 += $field[$j]*$fator2;
$fator2--;
if($fator2=2) {$fator2=9;}}
$rest2 = $total2%11;
if($rest2<2){$y=0;}
else {$y= 11-$rest2;}
return $y;
}

function cpa($field) {
  $fator = 2;
  $total = 0;
    for($i=0; $i<9; $i++) {
        $total += $field[$i]*$fator;
        $fator++;
  $rest = $total%11;
  if($rest<2){$x=0;}
  else {$x= 11-$rest;}
 return $x;
}
}

function cpaa($field) {
  $fator = 2;
  $total = 0;
    for($i=0; $i<10; $i++) {
        $total += $field[$i]*$fator;
        $fator++;}
  $rest = $total%11;
  if($rest<2){$x=0;}
  else {$x= 11-$rest;}
 return $x;
}


function validateCpfCnpj($field, $field_company='optional')
{
  if ($field == "") { return "cpfcnpj^Por favor, informe o CPF ou CNPJ*";}
            
  else if(strlen($field) == 14) {

          if(ca($field) != substr($field, 12, 1) && caa($field) != substr($field, 13, 1)) { 
            return "cpfcnpj^CNPJ inválido*"; }
          
          else if (strlen($field)==14 && $field_company=="") {
            return "companycpfcnpj$field^Por favor, informe o nome da empresa*";
          }

          else if (strlen($field)==14 && !preg_match('/[\s]/', $field_company)>0) {
            return "companycpfcnpj$field^Por favor, informe um nome de empresa válido*";
          }
          
          else { return $field."-okcp8RY5Mc58cpfcnpj*";}
  }

  else if(strlen($field) == 11) {

          if(cpa($field) != substr($field, 9, 1) && cpaa($field) != substr($field, 10, 1)) { 
          return "cpfcnpj^CPF inválido*"; }
    
          else { return $field."-okcp8RY5Mc58cpfcnpj*";}
  }

  else {return "cpfcnpj^Dígitos inválidos*"; }
};

//*****
function validateText($field) {
        if (preg_match('/[@_-]/', $field)>0) {
                return "msg^Caracteres invalidos*";}
        else { return $field."-okcp8RY5Mc58msg*"; }
}
//****

function insertContact($field)
{
  return $field."-okcp8RY5Mc58contact*";
}

function insertSpecialNotes($field)
{
  return $field."-okcp8RY5Mc58specialnotes*";
}

  
  ?>