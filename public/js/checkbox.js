function activateInput(checkbox)
{
  if(checkbox.checked)
  {
    document.getElementById(checkbox.value).readOnly = false;
  }

  else {
    document.getElementById(checkbox.value).readOnly = true;
  }
}
